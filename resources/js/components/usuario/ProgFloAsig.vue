<template>
  <v-container class="fill-height" fluid v-if="$store.state.auth">
    <v-row align="center" justify="center">
      <v-card class="mt-12 mx-auto">
        <v-card-title>{{ institucion }}</v-card-title>
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
              <td>{{ row.item.flo_id }}</td>
              <td>{{ row.item.pers_cedula }}</td>
              <td>{{ row.item.pers_nombres }}</td>
              <td>{{ row.item.pers_apellidos }}</td>
              <td>{{ row.item.mca_nombre }}</td>
              <td>{{ row.item.mod_nombre }}</td>
              <td>{{ row.item.vehi_placa }}</td>
              <td>{{ row.item.conp_lts }}</td>
              <td>
                <v-tooltip v-if="row.item.asignar" top>
                  <template v-slot:activator="{ on, attrs }">
                    <v-icon
                      v-bind="attrs"
                      v-on="on"
                      @click="asignar(row.item.flo_id)"
                      small
                      >mdi-car</v-icon
                    >
                  </template>
                  <span>Asignar</span>
                </v-tooltip>
              </td>
            </tr>
          </template>
        </v-data-table>
        <v-card-title v-if="datosasig != ''"> Asignados </v-card-title>
        <v-col cols="12" sm="4">
          <v-textarea
            v-if="datosasig != ''"
            rows="2"
            prepend-icon="mdi-comment"
            class="mx-2"
            counter
            label="Observación"
            v-model="observ"
          ></v-textarea>
        </v-col>

        <v-card-title v-if="datosasig != ''">
          <v-text-field
            v-model="searchasig"
            append-icon="mdi-magnify"
            label="Buscar"
            single-line
            hide-details
          ></v-text-field>
        </v-card-title>
        <v-data-table
          v-if="datosasig != ''"
          dense
          :headers="headers"
          :items="datosasig"
          :search="searchasig"
          item-key="name"
          class="elevation-1"
        >
          <template v-slot:item="row">
            <tr>
              <td>{{ row.item.flo_id }}</td>
              <td>{{ row.item.pers_cedula }}</td>
              <td>{{ row.item.pers_nombres }}</td>
              <td>{{ row.item.pers_apellidos }}</td>
              <td>{{ row.item.mca_nombre }}</td>
              <td>{{ row.item.mod_nombre }}</td>
              <td>{{ row.item.vehi_placa }}</td>
              <td>{{ row.item.conp_lts }}</td>
              <td>
                <v-tooltip v-if="row.item.asignar" top>
                  <template v-slot:activator="{ on, attrs }">
                    <v-icon
                      v-bind="attrs"
                      v-on="on"
                      @click="eliminar(row.item.flo_id)"
                      small
                      >mdi-car-off</v-icon
                    >
                  </template>
                  <span>Eliminar</span>
                </v-tooltip>
              </td>
            </tr>
          </template>
        </v-data-table>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            :disabled="datosasig.length == 0"
            color="primary"
            class="mr-4"
            @click="programar"
          >
            Programar
          </v-btn>
        </v-card-actions>
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
  name: "progfloasig",
  props: ["prog", "insti", "tipo"],
  data: () => ({
    snackbar: false,
    mensaje: "",
    search: "",
    searchasig: "",
    color: "",
    litrosasig: 0,
    litros: 0,
    institucion: "",
    datos: [],
    observ: "",
    datosasig: [],
    tipov: {},
    tipoitems: [
      { id: "1", nombre: "Automóvil" },
      { id: "2", nombre: "Motos" },
    ],
    headers: [
      { text: "Id flota", value: "flo_id" },
      { text: "Cédula", value: "pers_cedula" },
      { text: "Nombres", value: "pers_nombres" },
      { text: "Apellidos", value: "pers_apellidos" },
      { text: "Marca", value: "mca_nombre" },
      { text: "Modelo", value: "mod_nombre" },
      { text: "Placa", value: "vehi_placa" },
      { text: "Litros", value: "conp_lts" },
      { text: "Acciones", value: "" },
    ],
  }),
  mounted() {
    axios
      .get(`./programa/${this.prog}/edit`)
      .then((res) => {
        res.data.progra.map((prog) => {
          this.litrosasig = parseInt(prog.prog_lts);
        });
      })
      .catch((er) => {
        this.color = "red accent-2";
        this.mensaje = "Error al cargar los datos programación";
        this.snackbar = true;
      });
    axios
      .get(`./progrflota/${this.prog}/${this.insti}/${this.tipo}`)
      .then((res) => {
        //this.datos = res.data;
        if (res.data.progflot.length > 0) {
          this.institucion = res.data.progflot[0].inst_nombre;
        } else {
          this.color = "warning";
          this.mensaje = "No contiene flota";
          this.snackbar = true;
        }
        this.datos = res.data.progflot.map((prog) => {
          const asig = res.data.permisosuser.find(
            (el) => el.name === "proflo.user.desactivar"
          );

          return {
            flo_id: prog.flo_id,
            inst_nombre: prog.inst_nombre,
            pers_cedula: prog.pers_cedula,
            pers_nombres: prog.pers_nombres,
            pers_apellidos: prog.pers_apellidos,
            mca_nombre: prog.mca_nombre,
            mod_nombre: prog.mod_nombre,
            vehi_placa: prog.vehi_placa,
            conp_lts: prog.conp_lts,
            asignar: asig ? true : false,
          };
        });
        //para los ya programados de la flota
        this.datosasig = res.data.progflotactiva.map((progact) => {
          const asig = res.data.permisosuser.find(
            (el) => el.name === "proflo.user.desactivar"
          );
          this.litros += progact.conp_lts;
          return {
            flo_id: progact.flo_id,
            inst_nombre: progact.inst_nombre,
            pers_cedula: progact.pers_cedula,
            pers_nombres: progact.pers_nombres,
            pers_apellidos: progact.pers_apellidos,
            mca_nombre: progact.mca_nombre,
            mod_nombre: progact.mod_nombre,
            vehi_placa: progact.vehi_placa,
            conp_lts: progact.conp_lts,
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
    regresar() {
      setTimeout(() => this.$router.push({ name: "indexproflota" }), 2800);
    },
    asignar(id) {
      var tempo = this.datos.find((element) => element.flo_id == id);
      var litrostemp = this.litros;
      litrostemp += tempo.conp_lts;
      if (litrostemp <= this.litrosasig) {
        this.litros += tempo.conp_lts;
        this.datosasig.push(this.datos.find((element) => element.flo_id == id));
        this.datos = this.datos.filter((item) => item.flo_id !== id);
      } else {
        this.color = "red accent-2";
        this.mensaje =
          "No puedes pasar de los litros asignados a la programación";
        this.snackbar = true;
      }
    },
    eliminar(id) {
      var tempo = this.datosasig.find((element) => element.flo_id == id);
      this.litros -= tempo.conp_lts;
      this.datos.push(this.datosasig.find((element) => element.flo_id == id));
      this.datosasig = this.datosasig.filter((item) => item.flo_id !== id);
    },
    programar() {
      const progra = this.prog;
      const obs = this.observ;
      this.datosasig = this.datosasig.map((dat) => {
        return { ...dat, progra, obs };
      });
      const envio = {
        datos: this.datosasig,
        prog: this.prog,
        despa: "no",
      };
      axios
        .post("./progrflotaregist", envio)
        .then((res) => {
          this.color = "success";
          this.mensaje = res.data.mensaje;
          this.snackbar = true;
          this.regresar();
        })
        .catch((er) => {
          this.mensaje = er.response.data.mensaje;
          this.color = "red accent-2";
          this.snackbar = true;
        });
    },
  },
};
</script>