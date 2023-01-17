<template>
  <v-container class="fill-height" fluid v-if="$store.state.auth">
    <v-row align="center" justify="center" v-if="datosasig != ''">
      <v-card class="mt-12 mx-auto">
        <v-card-title>{{ institucion }}</v-card-title>
        <v-card-title v-if="datosasig != ''">
          Asignados y despachados por estación</v-card-title
        >
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
          <template v-slot:[`item.litros_paga`]="props">
            <v-edit-dialog
              @save="save(props.item, 1)"
              @cancel="cancel"
              @open="open"
              @close="close"
            >
              {{ props.item.litros_paga }}
              <template v-slot:input>
                <v-text-field
                  type="number"
                  min="0"
                  max="999"
                  maxlength="3"
                  :rules="litrospagaRules"
                  v-model="props.item.litros_paga"
                  label="Editar"
                  single-line
                  counter
                ></v-text-field>
              </template>
            </v-edit-dialog>
          </template>
          <template v-slot:[`item.litros_desp`]="props">
            <v-edit-dialog
              @save="save(props.item, 2)"
              @cancel="cancel"
              @open="open"
              @close="close"
            >
              {{ props.item.litros_desp }}
              <template v-slot:input>
                <v-text-field
                  type="number"
                  v-model="props.item.litros_desp"
                  label="Editar"
                  single-line
                  counter
                ></v-text-field>
              </template>
            </v-edit-dialog>
          </template>
          <template v-slot:[`item.asignar`]="row">
            <v-tooltip v-if="row.item.asignar" top>
              <template v-slot:activator="{ on, attrs }">
                <v-icon v-bind="attrs" v-on="on" @click="Actualizar" small
                  >mdi-content-save</v-icon
                >
              </template>
              <span>Guardar</span>
            </v-tooltip>
          </template>
        </v-data-table>
        <v-card-actions>
          <v-spacer></v-spacer>
        </v-card-actions>
        <v-snackbar v-model="snack" :timeout="3000" :color="snackColor">
          {{ snackText }}

          <template v-slot:action="{ attrs }">
            <v-btn v-bind="attrs" text @click="snack = false"> Close </v-btn>
          </template>
        </v-snackbar>
      </v-card>
    </v-row>
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
  </v-container>
</template>
<script>
export default {
  name: "despasigxesta",
  props: ["fecha", "insti"],
  data: () => ({
    snackbar: false,
    snack: false,
    snackColor: "",
    snackText: "",
    mensaje: "",
    search: "",
    searchasig: "",
    color: "",
    institucion: "",
    datos: [],
    observ: "",
    datosasig: [],
    tipov: {},
    litrospagaRules: [
      (v) => v <= 999 || "Máximo 999",
      (v) => v > 0 || "Mínimo 0",
    ],
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
      { text: "Litros pagado", value: "litros_paga" },
      { text: "Litros despachado", value: "litros_desp" },
      { text: "Acciones", value: "asignar" },
    ],
  }),
  mounted() {
    axios
      .get(`./progrflotaxesta/${this.fecha}/${this.insti}`)
      .then((res) => {
        this.datos = res.data;
        if (res.data.progflotactiva.length > 0) {
          this.institucion = res.data.progflot[0].inst_nombre;
        } else {
          this.color = "warning";
          this.mensaje = "La estacion no contiene flota asignada";
          this.snackbar = true;
          this.regresar();
        }
        //para los ya programados de la flota
        this.datosasig = res.data.progflotactiva.map((progact) => {
          const asig = res.data.permisosuser.find(
            (el) => el.name === "despaxesta.user.edit"
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
            litros_paga: progact.pflo_litros_paga,
            litros_desp: progact.pflo_litros_desp,
            pflo_prog_id: progact.pflo_prog_id,
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
    save(item, quien) {
      if (quien == 1) {
        if (item.litros_paga > 999) {
          for (let i = 0; i < this.datosasig.length; i++) {
            if (this.datosasig[i].flo_id === item.flo_id) {
              this.datosasig[i].litros_paga = 999;
              break;
            }
          }
        }
        if (item.litros_paga < 0) {
          for (let i = 0; i < this.datosasig.length; i++) {
            if (this.datosasig[i].flo_id === item.flo_id) {
              this.datosasig[i].litros_paga = 0;
              break;
            }
          }
        }
      }
      if (quien == 2) {
        if (item.litros_desp > 999) {
          for (let i = 0; i < this.datosasig.length; i++) {
            if (this.datosasig[i].flo_id === item.flo_id) {
              this.datosasig[i].litros_desp = 999;
              break;
            }
          }
        }
        if (item.litros_desp < 0) {
          for (let i = 0; i < this.datosasig.length; i++) {
            if (this.datosasig[i].flo_id === item.flo_id) {
              this.datosasig[i].litros_desp = 0;
              break;
            }
          }
        }
      }
      this.snack = true;
      this.snackColor = "success";
      this.snackText = "Data editada";
    },
    cancel() {
      this.snack = true;
      this.snackColor = "error";
      this.snackText = "Cancelado";
    },
    open() {
      this.snack = true;
      this.snackColor = "info";
      this.snackText = "Campo a editar";
    },
    close() {
      return true;
    },
    regresar() {
      setTimeout(() => this.$router.push({ name: "indexdespaxesta" }), 2800);
    },
    Actualizar() {
      const obs = this.observ;
      this.datosasig = this.datosasig.map((dat) => {
        return { ...dat, obs };
      });
      const envio = {
        datos: this.datosasig,
      };
      axios
        .post("./progrflotaregistxesta", envio)
        .then((res) => {
          this.color = "success";
          this.mensaje = res.data.mensaje;
          this.snackbar = true;
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