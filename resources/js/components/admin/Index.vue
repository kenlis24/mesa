<template>
  <v-container class="fill-height" fluid v-if="$store.state.auth">
    <v-row align="center" justify="center">
      <v-card class="mt-12 mx-auto">
        <div class="text-right">
          <v-btn v-if="create" outlined color="indigo" @click="registrar()">
            <v-icon dense>mdi-plus</v-icon>
            Registrar
          </v-btn>
        </div>
        <v-data-table
          dense
          :headers="headers"
          :items="datos"
          item-key="name"
          class="elevation-1"
        >
          <template v-slot:item="row">
            <tr>
              <td>{{ row.item.id }}</td>
              <td>{{ row.item.name }}</td>
              <td>{{ row.item.email }}</td>
              <td>
                <v-btn v-if="row.item.editar" icon @click="editar(row.item.id)">
                  <v-icon>mdi-lead-pencil</v-icon>
                </v-btn>
                <v-btn
                  v-if="row.item.eliminar"
                  icon
                  @click="eliminar(row.item.id)"
                >
                  <v-icon>mdi-delete</v-icon>
                </v-btn>
              </td>
            </tr>
          </template>
        </v-data-table>
        <v-snackbar
          :timeout="2500"
          v-model="snackbar"
          absolute
          :color="color"
          rounded="pill"
          right
        >
          {{ this.mensaje }}
        </v-snackbar>
      </v-card>
      <v-dialog v-model="dialog" persistent max-width="290">
        <v-card>
          <v-card-title class="text-h5"> Eliminar usuario </v-card-title>
          <v-card-text>Desea eliminar el usuario con sus roles</v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="green darken-1" text @click="eliminarusuario()">
              Si
            </v-btn>
            <v-btn color="green darken-2" text @click="dialog = false">
              No
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-row>
  </v-container>
</template>
<script>
export default {
  name: "userindex",
  data: () => ({
    snackbar: false,
    mensaje: "",
    id: "",
    color: "",
    dialog: false,
    datos: [],
    create: false,
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
        this.datos = res.data.usuarios.map((usu) => {
          const edit = res.data.permisosuser.find(
            (el) => el.name === "admin.user.edit"
          );
          const eliminar = res.data.permisosuser.find(
            (el) => el.name === "admin.user.destroy"
          );
          const crear = res.data.permisosuser.find(
            (el) => el.name === "admin.user.create"
          );
          if (crear) this.create = true;
          return {
            id: usu.id,
            name: usu.name,
            email: usu.email,
            editar: edit ? true : false,
            eliminar: eliminar ? true : false,
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
    editar(id) {
      this.$router.push({ name: "usersedit", params: { id: id } });
    },
    eliminar(id) {
      this.id = id;
      this.dialog = true;
    },
    eliminarusuario() {
      axios
        .delete(`./users/${this.id}`)
        .then((res) => {
          this.color = "success";
          this.mensaje = res.data.mensaje;
          this.snackbar = true;
          this.dialog = false;
          this.cargar();
        })
        .catch((er) => {
          this.color = "red accent-2";
          this.mensaje = er;
          this.snackbar = true;
        });
    },
    registrar() {
      this.$router.push({ name: "registrar" });
    },
    cargar() {
      axios
        .get("./users")
        .then((res) => {
          //this.datos = res.data;
          this.datos = res.data.usuarios.map((usu) => {
            const edit = res.data.permisosuser.find(
              (el) => el.name === "admin.user.edit"
            );
            const eliminar = res.data.permisosuser.find(
              (el) => el.name === "admin.user.destroy"
            );
            return {
              id: usu.id,
              name: usu.name,
              email: usu.email,
              editar: edit ? true : false,
              eliminar: eliminar ? true : false,
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
  },
};
</script>