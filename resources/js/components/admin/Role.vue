<template>
  <v-container class="fill-height" fluid v-if="$store.state.auth">
    <v-row align="center" justify="center">
      <v-card class="mt-12 mx-auto">
        <div class="text-right">
          <v-btn v-if="create" outlined color="indigo" @click="registrar()">
            <v-icon dense>mdi-plus</v-icon>
            Registrar Roles
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
          <v-card-title class="text-h5"> Eliminar Rol </v-card-title>
          <v-card-text>Esta seguro de eliminar el rol</v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="green darken-1" text @click="eliminarRol()">
              Si
            </v-btn>
            <v-btn color="green darken-1" text @click="dialog = false">
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
  name: "rolesindex",
  data: () => ({
    snackbar: false,
    mensaje: "",
    id: "",
    dialog: false,
    color: "",
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
      { text: "Acciones", value: "" },
    ],
  }),
  mounted() {
    axios
      .get("./roles")
      .then((res) => {
        //this.datos = res.data.roles;
        this.datos = res.data.roles.map((rol) => {
          const edit = res.data.permisosuser.find(
            (el) => el.name === "admin.role.edit"
          );
          const eliminar = res.data.permisosuser.find(
            (el) => el.name === "admin.role.destroy"
          );
          const crear = res.data.permisosuser.find(
            (el) => el.name === "admin.role.create"
          );
          if (crear) this.create = true;
          return {
            id: rol.id,
            name: rol.name,
            editar: edit ? true : false,
            eliminar: eliminar ? true : false,
          };
        });
      })
      .catch((er) => {
        this.color = "red accent-2";
        this.mensaje = er;
        this.snackbar = true;
      });
  },
  methods: {
    editar(id) {
      this.$router.push({ name: "rolesedit", params: { id: id } });
    },
    eliminar(id) {
      this.id = id;
      this.dialog = true;
    },
    eliminarRol() {
      axios
        .delete(`./roles/${this.id}`)
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
      this.$router.push({ name: "rolesregist" });
    },
    cargar() {
      axios
        .get("./roles")
        .then((res) => {
          //this.datos = res.data.roles;
          this.datos = res.data.roles.map((rol) => {
            const edit = res.data.permisosuser.find(
              (el) => el.name === "admin.role.edit"
            );
            const eliminar = res.data.permisosuser.find(
              (el) => el.name === "admin.role.destroy"
            );
            return {
              id: rol.id,
              name: rol.name,
              editar: edit ? true : false,
              eliminar: eliminar ? true : false,
            };
          });
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