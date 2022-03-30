<!--Компонент(Завести новую запись)-->
<template>
    <v-form>
            <v-row dense>
                <v-col
                    sm="12"
                    lg="4"
                    class="d-flex">
                    <v-text-field
                        v-model="complaint.numb_order"
                        item-value="id"
                        label="Приказ"
                        outlined
                        dense
                    ></v-text-field>
                </v-col>
                <v-col
                    sm="12"
                    lg="4"
                  >
                    <v-text-field
                        v-model="complaint.warranty_decree"
                        item-value="id"
                        item-text="number"
                        label="№ Гарантийного приказа"
                        outlined
                        dense
                    ></v-text-field>
                </v-col>

                <v-col
                    sm="6"
                    lg="4">
                    <base-date-picker
                        v-model="complaint.start_at"
                        dense
                        outlined
                        label="Дата начала рекламации">

                    </base-date-picker>
                </v-col>

                <v-col sm="4">
                    <v-select
                        v-model="complaint.warranty_type_id"
                        item-value="id"
                        item-text="name"
                        :items="warrantyTypes"
                        label="Гарантия"
                        dense
                        outlined
                    ></v-select>
                </v-col>
                <v-col
                    sm="4">
                    <v-select
                        v-model="complaint.reason_id"
                        item-value="id"
                        item-text="name"
                        :items="reasons"
                        label="Причина гарантии"
                        dense
                        outlined
                    ></v-select>
                </v-col>
                <v-col
                    sm="4">
                    <v-select
                        v-model="complaint.type_comp_id"
                        item-value="id"
                        item-text="name"
                        :items="type_comps"
                        label="Статус"
                        dense
                        outlined
                    ></v-select>
                </v-col>
                <v-col
                    sm="4">
                    <v-text-field
                        v-model="complaint.vehicle"
                        item-text="name"
                        dense
                        outlined
                        label="Вид надстройки"
                        rows="1"
                    ></v-text-field>
                </v-col>
                <v-col
                    sm="4">
                    <v-select
                        v-model="complaint.contractor_id"
                        item-value="id"
                        item-text="name"
                        dense
                        :items="contractors"
                        outlined
                        label="Заказчик"
                        rows="1"
                    ></v-select>
                </v-col>
                <v-col
                    sm="4">
                    <v-select
                        v-model="complaint.culprit_id"
                        item-value="id"
                        item-text="name"
                        :items="culprits"
                        label="Предполагаемый виновник"
                        dense
                        outlined
                    ></v-select>
                </v-col>
                <v-col
                    sm="4">
                    <v-select
                        v-model="complaint.executor_id"
                        item-value="id"
                        item-text="name"
                        :items="executors "
                        label="Устранение"
                        dense
                        outlined
                    ></v-select>
                </v-col>
                <v-col
                    sm="4">

<!--                    <base-file-input></base-file-input>-->

                    <v-text-field
                        v-if="false"
                    ></v-text-field>
<!--                    <comment></comment>-->


                </v-col>
            </v-row>
    </v-form>

</template>
<script>

import BaseDatePicker from "gird-base-front/src/components/BaseDatePicker";
import BaseFileInput from "gird-base-front/src/components/BaseFileInput";

export default {
    name: "ComponentWrite",

    components: {BaseDatePicker, BaseFileInput},
    props: {
        warrantyTypes: {  //гарантия
            type: Array,
            required: true
        },
        reasons: { //причина гарантии
            type: Array,
            required:true
        },
        type_comps:{      //тип гарантии
            type:Array,
            required:true
        },
        culprits:{      //виновник
            type:Array,
            required:true,
        },
        executors:{     //устранение
            type:Array,
            required:true,
        },

        contractors:{
          type:Array,
          required:true,
        },



        value: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            complaint: this.value,
            Calendar: null,

        }

    },
    methods: {
        close() {
            this.$emit('input', false);
        }
    },

}
</script>
<style scoped>

</style>
