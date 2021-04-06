<template>
  <div>
    <h2>{{ title }}</h2>
    <b-button block variant="outline-secondary" v-for="menu in menus">{{menu.title}}</b-button>
  </div>
</template>

<script>
module.exports = {
  data: function() {
    return {
      title: "Meniu",
      menus: [
        {title: 'Pagrindinis', component: 'index-content'},
        {title: 'Prekės', component: 'products-list'}
      ]
    }
  }
}
</script>

<style scoped>

</style>