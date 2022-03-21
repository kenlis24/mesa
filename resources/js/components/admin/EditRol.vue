<template>
  <v-container v-if="datos">
    <v-btn outlined color="indigo" @click="asignar()">Aceptar</v-btn>
    <v-card class="elevation-12">
      <v-toolbar color="primary" dark flat>
        <v-toolbar-title>Asignar permisos</v-toolbar-title>
        <v-spacer></v-spacer>
      </v-toolbar>
      <v-card-text>
        <label
          >Nombre del Rol
          <span class="d-flex flex-row mb-6"
            ><b>{{ datos.rol.name }}</b></span
          ></label
        >
        <v-spacer></v-spacer>

        <v-spacer></v-spacer>
        <v-simple-table fixed-header height="200px" dense>
          <template v-slot:default>
            <thead>
              <tr>
                <th class="text-left">Permisos</th>
                <th class="text-left">Activo</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in permisos" :key="item.id">
                <td>{{ item.description }}</td>
                <td>
                  <span v-if="item.existe" class="ml-3">
                    <input
                      type="checkbox"
                      :id="item.id"
                      :value="item.name"
                      v-model="nuevospermisos"
                    />
                  </span>
                  <span v-else class="ml-3">
                    <input
                      type="checkbox"
                      :id="item.id"
                      :value="item.name"
                      v-model="nuevospermisos"
                    />
                  </span>
                </td>
              </tr>
            </tbody>
          </template>
        </v-simple-table>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
      </v-card-actions>
    </v-card>
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
  </v-container>
</template>
<script>
export default {
  name: "editrol",
  props: ["id"],
  data() {
    return {
      datos: "",
      snackbar: false,
      color: "",
      permisos: [],
      mensaje: "",
      nuevospermisos: [],
    };
  },
  mounted() {
    axios
      .get(`./roles/${this.id}/edit`)
      .then((res) => {
        this.permisos = res.data.permisos.map((per) => {
          const nuevoper = res.data.permisosRol.find(
            (el) => el.name === per.name
          );
          if (nuevoper) this.nuevospermisos.push(per.name);
          return {
            id: per.id,
            name: per.name,
            description: per.description,
            existe: nuevoper ? true : false,
          };
        });
        this.datos = res.data;
      })
      .catch((er) => {
        this.datos = er;
      });
  },
  methods: {
    regresar() {
      setTimeout(() => this.$router.push({ name: "roles" }), 2800);
    },
    asignar() {
      var rol = {
        permisos: this.nuevospermisos,
      };
      axios
        .put(`./roles/${this.id}`, rol)
        .then((res) => {
          this.color = "success";
          this.mensaje = res.data.mensaje;
          this.snackbar = true;
          this.regresar();
        })
        .catch((er) => {
          this.color = "red accent-2";
          this.mensaje = er;
          this.snackbar = true;
        });
      //this.$router.push("users");
    },
  },
};
</script>
