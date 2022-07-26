<!--Компонент(Завести новую запись)-->
<template>
    <v-form>
            <v-row dense>
                <v-col
                cols="12">
                </v-col>
                <v-col
                    sm="12"
                    lg="2"
                    class="d-flex">
                    <v-text-field
                        v-model="complaint.numb_order"
                        item-value="id"
                        label="Приказ"
                        :error-messages="errors['numb_order']"
                        outlined
                        type="number"
                        dense
                    ></v-text-field>
                </v-col>
                <v-col
                    sm="12"
                    lg="2">
                    <base-date-picker
                        v-model="complaint.order_at"
                        :error-messages="errors['order_at']"
                        dense
                        outlined
                        label="Дата приказа">
                    </base-date-picker>
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
                        type="number"
                        dense
                    ></v-text-field>
                </v-col>

                <v-col
                    sm="6"
                    lg="4">
                    <base-date-picker
                        v-model="complaint.start_at"
                        :error-messages="errors['start_at']"
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
                        :error-messages="errors['vehicle']"
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
                        :error-messages="errors['executor_id']"
                        item-value="id"
                        item-text="name"
                        :items="executors"
                        label="Устранение"
                        outlined
                        multiple
                        dense
                    >

                    </v-select>

                </v-col>
                <v-col
                sm="4">
                        <base-date-picker
                            v-model="complaint.unload_at"
                            :error-messages="errors['unload_at']"
                            dense
                            outlined
                            label="Дата отгрузки шасси">
                        </base-date-picker>
                </v-col>
                <v-col
                    sm="4">

                    <v-combobox
                        v-model="complaint.chassises"
                        :error-messages="errors['chassises']"
                        label="Шасси"
                        :items="chassises"
                        small-chips
                        dense
                        solo
                        multiple
                        hide-selected

                    >
                    </v-combobox>

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
        errors: {
          type:Object,
          required:false
        },
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

        executor_id:{     //устранение
            type:Array,
            required:true,
        },

        chassises:{
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

        },

    },
    watch:{     //следить за изменением value
        value: {
            handler(value) {
                this.complaint = value;
            },
            immediate: true,
        },


    }

}
</script>
<style scoped>

</style>
