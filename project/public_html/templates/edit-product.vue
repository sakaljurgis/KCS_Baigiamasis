<template>
  <b-modal v-on:edit-product='showMe' id="editProduct" :title="title" hide-footer>
    <h3>{{title}}</h3>

    <b-form @submit="submitProduct">

      <b-form-group id="input-group-1" label="SKU:" label-for="sku">
        <b-form-input v-model="product.sku" placeholder="SKU" required></b-form-input>
      </b-form-group>

      <b-form-group label="Pavadinimas:" label-for="name">
        <b-form-input id="name" v-model="product.name" placeholder="Produkto Pavadinimas" required></b-form-input>
      </b-form-group>

      <b-form-group label="Aprašymas:" label-for="description">
        <b-form-input id="description" v-model="product.description" placeholder="Produkto Aprašymas"></b-form-input>
      </b-form-group>

      <b-form-group label="Kaina:" label-for="price">
        <b-form-input id="price" v-model="product.price" placeholder="0" type="number" step="0.01"></b-form-input>
      </b-form-group>

      <b-form-group label="Kiekis:" label-for="quantity">
        <b-form-input id="quantity" v-model="product.quantity" placeholder="0" type="number"></b-form-input>
      </b-form-group>

      <b-button type="submit" variant="primary">Pateikti</b-button>
      <b-button @click="hideMe" variant="danger">Atšaukti</b-button>

    </b-form>

  </b-modal>
</template>

<script>

module.exports = {
  data: function() {
    return {
      title: "Koreguoti",
      product: {},
      emptyProduct: {
        id: 0,
        sku: "",
        name: "",
        price: 0,
        quantity: 0,
        description: ""
      }
    }
  },
  methods: {
    submitProduct: function(event) {
      event.preventDefault();

      let newProduct = this.product.id ? false : true;
      let url = newProduct ? '/products' : '/products/' + this.product.id;
      let me = this;

      let formData = new FormData;
      let keys = Object.keys(this.product);

      for (let i = 0; i < keys.length; i++) {
        formData.append(keys[i], this.product[keys[i]]);
      }
      fetch(url, {
        method: 'POST',
        body: formData
      })
      .then(function (response){
        if (response.status != 200) {
          response.text().then(data => {
            me.$bvToast.toast(data, {
              title: 'Klaida',
              variant: 'danger',
              toaster: 'b-toaster-top-center',
              autoHideDelay: 3000
            })
          })
        } else {
          response.json().then(product => {
            if (newProduct) {
              me.$parent.$emit('product-created', product);
            } else {
              me.$parent.$emit('product-updated', product);
            }
          });
          me.hideMe();
        }
      })
    },
    hideMe: function() {
      this.$bvModal.hide('editProduct');
    },
    showMe: function() {
      this.$bvModal.show('editProduct');
    }
  },
  created: function() {

    let me = this;

    this.$parent.$on('edit-product', function (product) {
      me.product = JSON.parse(JSON.stringify(me.emptyProduct));
      me.title = "Sukurti Naują";
      if (product) {
        me.title = "Koreguoti produktą: '" + product.name + "'";
        //me.product = product;
        me.product.id = product.id;
        me.product.sku = product.sku;
        me.product.name = product.name;
        me.product.price = product.price;
        me.product.quantity = product.quantity;
        me.product.description = product.description;
      }
      me.showMe();
    });

    this.$parent.$on('delete-product', function (id) {
      let url = '/products/' + id;
      fetch(url, {
        method: 'DELETE'
      })
      .then(function (response){
        if (response.status != 200) {
          response.text().then(data => {
            me.$bvToast.toast(data, {
              title: 'Klaida',
              variant: 'danger',
              toaster: 'b-toaster-top-center',
              autoHideDelay: 3000
            })
          })
        } else {
          me.$parent.$emit('product-deleted', id)
        }
      })
    });

  }
}

</script>