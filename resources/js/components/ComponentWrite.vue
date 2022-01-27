<!--Компонент(Завести новую запись)-->
<template>
    <v-card
        class="mx-auto"
        max-width="800"
        elevation="0"
        max-height="900"
        outlined>
        <v-card-actions>
            <v-container>
                <v-row dense>
                    <v-col
                        sm="12"
                        lg="4"
                        class="d-flex">
                        <v-text-field
                            label="Приказ"
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>
                    <v-col
                        sm="12"
                        lg="4"
                        class="d-flex">
                        <v-text-field
                            label="№ Гарантийного приказа"
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>

                    <v-col
                        sm="6"
                        lg="4">
                        <base-date-picker v-model="date" dense outlined label="Дата начала рекламации">

                        </base-date-picker>
                    </v-col>

                    <v-col
                        sm="4">
                        <v-select
                            v-model="selWarranty"
                            item-value="id"
                            item-text="name"
                            :items="itemsWarranty "
                            label="Гарантия"
                            dense
                            outlined
                        ></v-select>
                    </v-col>
                    <v-col
                        sm="4">
                        <v-select
                            v-model="causeWarranty"
                            item-value="id"
                            item-text="name"
                            :items="itemsCause"
                            label="Причина гарантии"
                            dense
                            outlined
                        ></v-select>
                    </v-col>
                    <v-col
                        sm="4">
                        <v-select
                            v-model="statusWarranty"
                            item-value="id"
                            item-text="name"
                            :items="itemsStatus"
                            label="Статус"
                            dense
                            outlined
                        ></v-select>
                    </v-col>
                    <v-col
                        sm="4">
                        <v-text-field
                            dense
                            outlined
                            label="Вид надстройки"
                            rows="1"
                        ></v-text-field>
                    </v-col>
                    <v-col
                        sm="4">
                        <v-text-field
                            dense
                            outlined
                            label="Заказчик"
                            rows="1"
                        ></v-text-field>
                    </v-col>
                    <v-col
                        sm="4">
                        <v-select
                            v-model="companyCul"
                            item-value="id"
                            item-text="name"
                            :items="itemCompany"
                            label="Предполагаемый виновник"
                            dense
                            outlined
                        ></v-select>
                    </v-col>
                    <v-col
                        sm="4">
                        <v-select
                            v-model="correctProblem"
                            item-value="id"
                            item-text="name"
                            :items="itemCorrect "
                            label="Устранение"
                            dense
                            outlined
                        ></v-select>
                    </v-col>
                    <v-col
                        sm="4">

                        <base-file-input></base-file-input>
                        <v-text-field
                            v-if="false"
                        ></v-text-field>
                        <comment></comment>
                        <!--                        <v-file-input
                                                    chips
                                                    dense
                                                    multiple
                                                    label="Добавить файлы"
                                                ></v-file-input>
                                            </v-col>
                                       <v-col
                                                sm="2">
                                                <comment ></comment>
                                            </v-col>&ndash;&gt;

                                            <v-col
                                            sm="4">
                                                <v-textarea
                                                    dense
                                                    rows="1"
                                                    label = "Комментарий"
                                                ></v-textarea>-->

                    </v-col>
                </v-row>
            </v-container>

        </v-card-actions>
        <!--card нижний колотитул        -->

<!--        <v-card-actions>-->
<!--            <v-btn-->
<!--                outlined-->
<!--                rounded-->
<!--                text>-->
<!--                Отмена-->
<!--            </v-btn>-->
<!--            <v-spacer></v-spacer>-->
<!--            <v-btn-->
<!--                outlined-->
<!--                rounded-->
<!--                text-->
<!--                color="primary">-->
<!--                Сохранить-->
<!--            </v-btn>-->

<!--        </v-card-actions>-->

    </v-card>
</template>
<script>

import BaseDatePicker from "gird-base-front/src/components/BaseDatePicker";
import BaseFileInput from "gird-base-front/src/components/BaseFileInput";

export default {
    name: "ComponentWrite",

    components: {BaseDatePicker, BaseFileInput},
    data() {
        return {
            selWarranty: null,
            itemsWarranty: [
                // {id: 1, name: 'Политика'},
                // {id: 2, name: 'Производство'},
            ],

            statusWarranty: null,
            itemsStatus: [
                {id: 1, name: 'Гарантийный'},
                {id: 2, name: 'Не гарантийный'}
            ],

            causeWarranty: null,
            itemsCause: [
                {id: 1, name: 'Поставщик'}, {id: 2, name: 'Фургон'}, {id: 3, name: 'Металлоконструкция'}, {
                    id: 4,
                    name: 'ЛКП'
                },
                {id: 5, name: 'Сборка'}, {id: 6, name: 'Шасси'}, {id: 7, name: 'КМУ'}, {id: 8, name: 'Комплектующие'}],

            companyCul: null,
            itemCompany: [{id: 1, name: 'Поставщик'}, {id: 2, name: 'Производство'},
                {id: 3, name: 'Конструкция'}, {id: 4, name: 'Приемка ОТК'}, {id: 5, name: 'Потребитель'}],

            correctProblem: null,
            itemCorrect: [{id: 1, name: 'Поставщик'}, {id: 2, name: 'Командировка(Производитель)'},
                {id: 3, name: 'Силами заказчика'}, {id: 4, name: 'Сторонняя Организация'}],


            Calendar: null,
            date: new Date().toISOString().substr(0, 10),


            DataOther: null,

            OtherCheckbox: false,

            files: [],

        }


    },
    methods: {
        close() {
            this.$emit('input', false);
        },
        guarantee(){
            api.call(endpoint('guarantee'))
                .then(response => {
                    this.itemsWarranty = response.data;
                });
        }
    },

    created() {
        this.guarantee();
    }


}
</script>
<style scoped>

</style>
