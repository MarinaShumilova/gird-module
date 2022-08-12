<!--Компенсация-->
<template>
    <v-dialog
        :value="value"
        width="400"
        scrollable
        persistent>
        <v-card>
            <v-toolbar
                elevation="1"
                height="50">
                <span>
                    <v-icon>mdi-cash-multiple</v-icon>
                   Компенсация
                </span>
                <v-spacer></v-spacer>
                <v-btn icon color="error" @click="close">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-toolbar>
            <v-container>
                <v-row>
                    <v-col sm="5">
                        <!--                        <v-menu-->
                        <!--                            ref="menu"-->
                        <!--                            v-model="menu"-->
                        <!--                            :close-on-content-click="false"-->
                        <!--                            :return-value.sync="date"-->
                        <!--                            transition="fade-transition"-->
                        <!--                            offset-y-->
                        <!--                            max-width="290px"-->
                        <!--                            min-width="auto">-->
                        <!--                            <template v-slot:activator="{ on, attrs }">-->
                        <!--                                <v-text-field-->
                        <!--                                    v-model="date"-->
                        <!--                                    label="Период компенсации"-->
                        <!--                                    prepend-icon="mdi-calendar"-->
                        <!--                                    readonly-->
                        <!--                                    dense-->
                        <!--                                    v-bind="attrs"-->
                        <!--                                    v-on="on"-->
                        <!--                                ></v-text-field>-->
                        <!--                            </template>-->
                        <BaseMonthPicker
                            v-model="redress.redress_at"
                            outlined
                            dense
                            type="month"
                        >

                        </BaseMonthPicker>
                        <!--                        </v-menu>-->
                    </v-col>
                    <v-col sm="7"
                           align="right">
                        <v-text-field
                            v-model="redress.expenses_redress"
                            type="number"
                            label="Сумма компенсации"
                            value="0"
                            dense
                            outlined
                            suffix="₽">
                        </v-text-field>
                    </v-col>
                    <v-col sm="7"
                           align="center">
                        <v-list>
                            <v-list-item
                                v-for="item in expenses_list"
                                :key="item.id"
                            >
                                <v-list-item-title>{{ item }}
                                    <v-divider></v-divider>
                                </v-list-item-title>

                                <v-btn icon

                                >
                                    <v-icon small color="red">mdi-bucket</v-icon>
                                </v-btn>
                            </v-list-item>
                        </v-list>

                    </v-col>
                    <v-col sm="12">
                        <v-textarea
                            v-model="redress.comment"

                            dense
                            label="Комментарии"
                            outlined
                            auto-grow

                            rows="2">
                        </v-textarea>

                    </v-col>

                </v-row>
                <v-card-text>
                    <v-card-actions>
                        <v-btn
                            :disabled="loading"
                            text
                            @click="close"
                        >
                            Отмена
                        </v-btn>
                        <v-spacer></v-spacer>
                        <v-btn
                            :loading="loading"
                            text
                            color="primary"

                        >
                            Сохранить
                        </v-btn>
                    </v-card-actions>
                </v-card-text>

            </v-container>
        </v-card>

    </v-dialog>
</template>
<script>
import BaseMonthPicker from "./BaseMonthPicker";
import BaseFileInput from "gird-base-front/src/components/BaseFileInput";

export default {
    components: {BaseMonthPicker, BaseFileInput},
    name: "ComponentRedress",
    props: {
        value: {
            type: Boolean,
            required: true,
        },
        compId: {
            type: Number,
            required: true
        },
    },
    data() {
        return {
            menu: false,
            dialog: this.value,
            loading: false,
            expenses_list: [],
            date: new Date().toISOString().substr(0, 7),
            redress: {
                redress_at: new Date().toISOString().substr(0, 7),
                complaint_id: this.compId,
                comment: '',
                expenses_redress: null,
            },
        }
    },
    methods: {
        close() {
            this.$emit('input', false);
        },
    },
}

</script>
