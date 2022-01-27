<!--Прикрепить файл-->
<template>
    <v-row justify="center">
        <v-col
            sm="10">
            <base-date-picker v-model="date" dense outlined label="Дата перенаправления">
            </base-date-picker>
        </v-col>
        <v-col
            sm="8">
            <v-file-input
                chips
                dense
                multiple
                label="Загрузить документ"
            ></v-file-input>

        </v-col>
        <v-col sm="2">
            <comment></comment>
        </v-col>

    </v-row>
</template>

<script>
import Comment from "./Comment";
import BaseDatePicker from "gird-base-front/src/components/BaseDatePicker";

export default {
    component: {Comment, BaseDatePicker},
    data(){

    },
}
</script>
