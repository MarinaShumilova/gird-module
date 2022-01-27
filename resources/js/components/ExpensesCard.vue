<!--Затраты-->
<template>
    <v-dialog
        :value="value"
        width="300"
        scrollable
        persistent>

        <v-card>
            <v-toolbar height="50" elevation="1">
                <span>
                    <v-icon>mdi-card-bulleted-outline</v-icon>
                    Затраты
                </span>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                    <v-btn icon color="error" @click="close">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-toolbar-items>
            </v-toolbar>
            <v-card-text>
                <v-row justify="center"
                  >
                    <v-col
                        sm="10">
                        <BaseMonthPicker v-model="month" dense outlined type="month" label="Период">
                        </BaseMonthPicker>
                    </v-col>
                    <v-col sm="10"
                           align="center">
                        <v-text-field
                            type="number"
                            label="Сумма затрат за период"
                            value="0"
                            dense
                            outlined
                            suffix="₽">
                        </v-text-field>
                    </v-col>
                </v-row>

                <v-subheader>Затраты</v-subheader>
                <v-divider></v-divider>
                <v-list-item
                    v-for="item in expensAdd"
                    :key="item.summa"
                >
                    <v-list-item-title>{{ item.summa }}</v-list-item-title>

                    <v-list-item-icon>
                        <v-btn icon ><v-icon small color="red">mdi-bucket</v-icon></v-btn>
                    </v-list-item-icon>

                </v-list-item>
                <v-divider></v-divider>
            </v-card-text>




            <v-card-actions>
                <v-btn
                    outlined
                    rounded
                    text
                >
                    Отмена
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn
                    outlined
                    rounded
                    text
                    color="primary"
                >
                    Сохранить
                </v-btn>
            </v-card-actions>

        </v-card>
    </v-dialog>


</template>
<script>
import BaseMonthPicker from "./BaseMonthPicker";


export default {
    components: {BaseMonthPicker},
    name: "ExpensesCard",
    props: {
        value: {
            type: Boolean,
            required: true,
        },
    },

    data() {
        return {
            month: new Date().toISOString().substr(0, 7),
            expensAdd:[{
                summa:'56 000', icon:'mdi-bucket'
            },
            ],


        }
    },
    methods: {
        close() {
            this.$emit('input', false);
        },
    }
}

</script>
