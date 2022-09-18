<template>
  <v-container class="fill-height" fluid v-if="$store.state.auth">
    <v-row align="center" justify="center">
      <v-card class="mt-12 mx-auto">
        <div class="text-center text-h6">ASIGNAR INSTITUCIONES</div>
        <v-card-title>
          <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Buscar"
            single-line
            hide-details
          ></v-text-field>
        </v-card-title>
        <v-data-table
          dense
          :headers="headers"
          :items="datos"
          :search="search"
          item-key="name"
          class="elevation-1"
        >
          <template v-slot:item="row">
            <tr>
              <td>{{ row.item.id }}</td>
              <td>{{ row.item.name }}</td>
              <td>{{ row.item.email }}</td>
              <td>
                <v-tooltip v-if="row.item.asignar" top>
                  <template v-slot:activator="{ on, attrs }">
                    <v-icon
                      v-bind="attrs"
                      v-on="on"
                      @click="asignar(row.item.id)"
                      small
                      >mdi-office-building</v-icon
                    >
                  </template>
                  <span>Asignar institución</span>
                </v-tooltip>
              </td>
            </tr>
          </template>
        </v-data-table>
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
    </v-row>
  </v-container>
</template>
<script>
export default {
  name: "indexasiginsti",
  data: () => ({
    snackbar: false,
    mensaje: "",
    search: "",
    id: "",
    color: "",
    datos: [],
    headers: [
      {
        text: "ID",
        align: "start",
        sortable: false,
        value: "id",
      },
      { text: "Nombre", value: "name" },
      { text: "Correo", value: "email" },
      { text: "Acciones", value: "" },
    ],
  }),
  mounted() {
    axios
      .get("./users")
      .then((res) => {
        //this.datos = res.data;

        this.datos = res.data.usuarios.map((listuser) => {
          const asig = res.data.permisosuser.find(
            (el) => el.name === "asiginsti.admin.desactivar"
          );
          return {
            id: listuser.id,
            name: listuser.name,
            email: listuser.email,
            asignar: asig ? true : false,
          };
        });
        //window.location.reload();
      })
      .catch((er) => {
        this.color = "red accent-2";
        this.mensaje = er;
        this.snackbar = true;
      });
  },
  methods: {
    asignar(id) {
      this.$router.push({
        name: "asiginsti",
        params: { id: id },
      });
    },
  },
};
</script>