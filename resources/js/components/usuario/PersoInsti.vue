<template>
  <v-container class="fill-height" fluid v-if="$store.state.auth">
    <v-row align="center" justify="center">
      <v-card class="mt-12 mx-auto">
        <div class="text-center text-h6">Asignar institución</div>
      </v-card>
    </v-row>
  </v-container>
</template>
<script>
export default {
  name: "persoinsti",
  data: () => ({}),
  methods: {},
};
</script>