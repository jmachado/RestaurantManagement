<template>
  <div>
    <div class="jumbotron">
      <h1>Create meal</h1>
    </div>

    <div class="alert" :class="{'alert-success':showSuccess,'alert-danger':showFailure}" v-if="showSuccess || showFailure">
      <strong>{{successMessage}}</strong>
      <strong>{{failMessage}}</strong>
    </div>

    <div>
      <label for="table_number">Table Number</label>
      <select class="custom-select" v-model="selectedOption">
        <option disabled selected>-- Select a table --</option>
        <option v-for="table in tablesWithoutActiveMealsAtTheMoment" v-bind:key="table.table_number">{{table.table_number}}</option>
      </select>

      <button type="button" class="btn btn-outline-success" v-on:click.prevent="createMeal(selectedOption)">Create Meal</button>
      <button type="button" class="btn btn-outline-danger" v-on:click.prevent="goBack">Cancel</button>
    </div>
  </div>
</template>
<script>
  module.exports = {
    data() {
      return {
        tablesWithoutActiveMealsAtTheMoment: [],
        selectedOption: null,
        successMessage: "",
        failMessage: "",
        showSuccess: false,
        showFailure: false
      };
    },
    methods: {
      createMeal: function (table_number) {
        axios.post("/api/meals/createMealOnTable/" + table_number + "/onWaiter/" + this.$store.getters.getAuthUser.id)
          .then(response => {
            this.successMessage = "Meal created successfully!";
            this.showSuccess = true;
            this.goBack();
          })
          .catch(function (error) {
            console.log(error);
            this.failMessage = "Meal not created!";
            this.showFailure = true;
          });
      },
      goBack() {
        this.$router.go(-1);
      },
    },
    mounted() {
      axios.get("/api/meals/tablesWithoutActiveMeals")
        .then(response => {
          this.tablesWithoutActiveMealsAtTheMoment = response.data;
        });
    }
  };
</script>