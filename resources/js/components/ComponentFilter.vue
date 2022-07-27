<template>
    <v-row justify="space-around">
        <v-col
            sm="3">
            <v-select
                dense
                label="Статус"
                multiple
            ></v-select>
        </v-col>
        <v-col sm="3">
            <v-menu
                ref="menu"
                v-model="menu"
                :close-on-content-click="false"
                :return-value.sync="date"
                transition="scale-transition"
                offset-y
                max-width="290px"
                min-width="auto">
                <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                        v-model="date"
                        label="Период"
                        prepend-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                    ></v-text-field>
                </template>
                <base-month-picker
                    v-model="date"
                    type="month"
                    no-title
                    scrollable
                    multiple>
                    <v-spacer></v-spacer>
                    <v-btn
                        text
                        color="primary"
                        @click="menu = false"
                    >
                        Cancel
                    </v-btn>
                    <v-btn
                        text
                        color="primary"

                    >
                        OK
                    </v-btn>
                </base-month-picker>
            </v-menu>
        </v-col>
    </v-row>

</template>



<script>

import BaseMonthPicker from "./BaseMonthPicker";
export default {
    components:{BaseMonthPicker},
    name:"ComponentFilter",
    props: {
        value: {
            type: Boolean,
            required: true,
        },
     },
}

</script>
