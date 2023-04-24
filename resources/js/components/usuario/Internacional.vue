<template>
  <v-container class="fill-height" fluid v-if="$store.state.auth">
    <v-row justify="center">
      <v-col cols="4">
        <v-card class="mt-12">
          <div class="text-center text-h6">Estación Internacional</div>
          <v-row align="center">
            <v-col align="center" md="6" sm="12">
              <v-btn v-if="listar" outlined color="indigo" @click="lista">
                listar
              </v-btn>
            </v-col>
            <v-col align="center" md="6" sm="12">
              <v-btn v-if="create" outlined color="indigo" @click="registrar">
                Registrar
              </v-btn>
            </v-col>
          </v-row>

          <v-card-title> </v-card-title>

          <v-snackbar
            bottom
            :timeout="2500"
            v-model="snackbar"
            :color="color"
            rounded="pill"
            right
          >
            {{ this.mensaje }}
          </v-snackbar>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
export default {
  name: "indexinternacional",
  data: () => ({
    snackbar: false,
    show: false,
    color: "",
    create: false,
    listar: false,
    mensaje: "",
  }),
  mounted() {
    axios
      .get("./internacional")
      .then((res) => {
        const crear = res.data.permisosuser.find(
          (el) => el.name === "inter.user.create"
        );
        const lista = res.data.permisosuser.find(
          (el) => el.name === "inter.user.index"
        );
        if (crear) this.create = true;
        if (lista) this.listar = true;

        //window.location.reload();
      })
      .catch((er) => {
        this.color = "red accent-2";
        this.mensaje = er;
        this.snackbar = true;
      });
  },
  methods: {
    registrar() {
      this.$router.push({ name: "interregist" });
    },
    lista() {
      this.$router.push({ name: "interlistar" });
    },
  },
};
</script>