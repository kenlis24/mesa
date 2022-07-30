<template>
  <v-container class="fill-height" fluid v-if="$store.state.auth">
    Mantenimiento{{ id }}
  </v-container>
</template>
<script>
export default {
  name: "progfloasig",
  props: ["id"],
  data: () => ({
    snackbar: false,
    mensaje: "",
    search: "",
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
      { text: "Fecha programación", value: "prog_fecha" },
      { text: "Litros", value: "prog_lts" },
      { text: "Condicion", value: "prog_condicion" },
      { text: "Institución", value: "prog_inst_id" },
      { text: "Estación", value: "prog_inst_id_es" },
      { text: "Acciones", value: "" },
    ],
  }),
  mounted() {
    /* axios
      .get("./programa/flo")
      .then((res) => {
        //this.datos = res.data;

        this.datos = res.data.progra.map((prog) => {
          var condi = "";
          if (prog.prog_condicion == 1) condi = "Creado";
          if (prog.prog_condicion == 2) condi = "Programado";
          if (prog.prog_condicion == 3) condi = "Aprobado";

          const edit = res.data.permisosuser.find(
            (el) => el.name === "admin.user.edit"
          );
          const crear = res.data.permisosuser.find(
            (el) => el.name === "admin.user.create"
          );
          if (crear) this.create = true;
          return {
            id: prog.id,
            prog_fecha: prog.prog_fecha.slice(0, 10),
            prog_lts: prog.prog_lts,
            prog_condicion: condi,
            prog_inst_id: prog.institu,
            prog_inst_id_es: prog.estacion,
            inst_estado: prog.inst_estado,
            esta_estado: prog.esta_estado,
            editar: edit ? true : false,
            asignar: crear ? true : false,
          };
        });
        //window.location.reload();
      })
      .catch((er) => {
        this.color = "red accent-2";
        this.mensaje = er;
        this.snackbar = true;
      }); */
  },
  methods: {
    editar(id) {
      this.$router.push({ name: "programaedit", params: { id: id } });
    },
    activo(valor) {
      if (valor.inst_estado == "A" && valor.esta_estado == "A") {
        return "";
      } else return "warning";
    },
    asignar() {
      this.$router.push({ name: "progfloasig", params: { id: id } });
    },
  },
};
</script>