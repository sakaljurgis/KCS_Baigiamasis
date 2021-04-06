<template>
  <div>
    <h2>Produktai</h2>
    <div>
      <b-table striped hover :items="products" :fields="fields" :current-page="currentPage" :per-page="perPage" primary-key="id">
        <template #cell(actions)="row">
          <b-button size="sm" @click="row.toggleDetails" class="mr-2">
            {{ row.detailsShowing ? 'Paslėpti' : 'Detalės'}}
          </b-button>
          <b-button size="sm" @click="editProduct(row.item)" v-b-tooltip.hover title="Koreguoti" class="mr-2">
            <b-icon icon="pencil"></b-icon>
          </b-button>
          <b-button size="sm" @click="deleteProduct(row.item.id)" v-b-tooltip.hover title="Ištrinti">
            <b-icon icon="trash"></b-icon>
          </b-button>
        </template>

        <template #row-details="row">
          <b-card>
            <b-row class="mb-2">
              <b-col sm="3" class="text-sm-right"><b>Aprašymas:</b></b-col>
              <b-col>{{ row.item.description }}</b-col>
            </b-row>
            <b-row class="mb-2">
              <b-col sm="3" class="text-sm-right"><b>Sukurtas:</b></b-col>
              <b-col>{{ row.item.created_at }}</b-col>
            </b-row>
            <b-row class="mb-2">
              <b-col sm="3" class="text-sm-right"><b>Koreguotas:</b></b-col>
              <b-col>{{ row.item.updated_at }}</b-col>
            </b-row>
          </b-card>
        </template>

      </b-table>
      <b-pagination
          v-model="currentPage"
          :total-rows="totalRows"
          :per-page="perPage"
          align="fill"
          size="sm"
      ></b-pagination>
      <b-button @click="createNewProduct" variant="success" class="mb-1">Sukurti Naują</b-button>
    </div>
    <edit-product></edit-product>
  </div>
</template>

<script>
var hash = Math.random().toString(36).substring(2, 8) // prevent caching
module.exports = {
  data: function () {
    return {
      fields: [
        "sku",
        {key: "name", label: "Pavadinimas"},
        {key: "price", label: "Kaina"},
        {key: "quantity", label: "Likutis"},
        {key: "actions", label: "Veiksmai"}
      ],
      products: [],
      totalRows: 1,
      perPage: 10,
      currentPage: 1,
    }
  },
  created() {
    fetch("/products")
        .then(response => response.json())
        .then(json => {
          this.products = json;
          this.totalRows = this.products.length;
        });

    let me = this;

    this.$on('product-created', function (product){
      me.products.push(product);
      me.totalRows = this.products.length;
      me.currentPage = Math.ceil(this.totalRows/this.perPage);
    });

    this.$on('product-updated', function (product){
      index = -1;
      for (let i = 0; i < me.products.length; i++) {
        if (me.products[i].id == product.id) {
          index = i;
          break;
        }
      }
      if (index > -1) {
        me.products.splice(index, 1, product);
        me.totalRows = me.products.length;

        this.$bvToast.toast("Produktas #" + product.id + " sėkmingai atnaujintas", {
          title: 'Produktas Atnaujintas',
          variant: 'success',
          autoHideDelay: 3000
        })
      } else {
        this.$bvToast.toast("Įvyko klaida atnaujinant produktą #" + product.id, {
          title: 'Klaida',
          variant: 'danger',
          autoHideDelay: 3000
        })
      }
    });

    this.$on('product-deleted', function (id){
      index = -1;
      for (let i = 0; i < me.products.length; i++) {
        product = me.products[i];
        if (product.id == id) {
          index = i;
          break;
        }
      }
      if (index > -1) {
        me.products.splice(index, 1);
        me.totalRows = me.products.length;

        me.$bvToast.toast("Sėkmingai ištrintas produktas #" + id, {
          title: 'Produktas Ištrintas',
          variant: 'success',
          autoHideDelay: 3000
        })
      } else {
        me.$bvToast.toast("Įvyko klaida ištrinant produktą #" + id, {
          title: 'Klaida',
          variant: 'danger',
          autoHideDelay: 3000
        })
      }
    })
  },
  methods: {
    deleteProduct(id) {
      this.$emit('delete-product', id);
    },
    editProduct(product) {
      //let product_copy = JSON.parse(JSON.stringify(product));
      //this.$emit('edit-product', product_copy);
      this.$emit('edit-product', product);
    },
    createNewProduct() {
      this.$emit('edit-product');
    }
  },
  components: {
    'edit-product': httpVueLoader('./edit-product.vue?' + hash)
  }
}
</script>

<style scoped>

</style>