<template>
  <v-container class="fill-height" fluid v-if="$store.state.auth">
    <v-row align="center" justify="center">
      <v-card class="mt-12 mx-auto">
        <div class="text-center text-h6">DESPACHO COMBUSTIBLE POR USUARIO</div>
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
            <tr
              :class="activo(row.item)"
              :title="
                activo(row.item) != ''
                  ? 'La Institución o Estacion esta inactiva'
                  : ''
              "
            >
              <td>{{ row.item.id }}</td>
              <td>{{ row.item.prog_fecha }}</td>
              <td>{{ row.item.prog_lts }}</td>
              <td>{{ row.item.prog_condicion }}</td>
              <td>{{ row.item.prog_inst_id }}</td>
              <td>{{ row.item.prog_inst_id_es }}</td>
              <td>
                <v-tooltip v-if="row.item.asignar" top>
                  <template v-slot:activator="{ on, attrs }">
                    <v-icon
                      v-bind="attrs"
                      v-on="on"
                      @click="
                        (row.item.esta_estado || row.item.inst_estado) != 'A'
                          ? ''
                          : asignar(
                              row.item.id,
                              row.item.insti_id,
                              row.item.prog_tipo_vehi
                            )
                      "
                      :disabled="
                        (row.item.esta_estado || row.item.inst_estado) != 'A'
                      "
                      small
                      >mdi-gas-station-outline</v-icon
                    >
                  </template>
                  <span>Despachado</span>
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
  name: "indexdespacho",
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
      { text: "Fecha programación", value: "prog_fecha" },
      { text: "Litros", value: "prog_lts" },
      { text: "Condicion", value: "prog_condicion" },
      { text: "Institución", value: "prog_inst_id" },
      { text: "Estación", value: "prog_inst_id_es" },
      { text: "Acciones", value: "" },
    ],
  }),
  mounted() {
    axios
      .get("./programa/despa/comb/comb")
      .then((res) => {
        //this.datos = res.data;

        this.datos = res.data.progra.map((prog) => {
          var condi = "";
          if (prog.prog_condicion == 3) condi = "Aprobado";

          const asig = res.data.permisosuser.find(
            (el) => el.name === "despacho.user.edit"
          );
          return {
            id: prog.id_prog,
            prog_fecha: prog.prog_fecha.slice(0, 10),
            prog_lts: prog.prog_lts,
            prog_condicion: condi,
            insti_id: prog.insti_id,
            prog_inst_id: prog.institu,
            prog_tipo_vehi: prog.prog_tipo_vehi,
            prog_inst_id_es: prog.estacion,
            inst_estado: prog.inst_estado,
            esta_estado: prog.esta_estado,
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
    activo(valor) {
      if (valor.inst_estado == "A" && valor.esta_estado == "A") {
        return "";
      } else return "warning";
    },
    asignar(id, insti, tipo) {
      this.$router.push({
        name: "despasig",
        params: { prog: id, insti: insti, tipo: tipo },
      });
    },
  },
};
</script>