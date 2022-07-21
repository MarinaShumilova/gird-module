<!--Прикрепить файл-->
<template>
    <v-dialog
        :value="value"
        width="300"
        scrollable
        persistent
    >
<!--    <v-row justify="center">-->
<!--        <v-col-->
<!--            sm="10">-->
<!--            <base-date-picker v-model="date" dense outlined label="Дата перенаправления">-->
<!--            </base-date-picker>-->
<!--        </v-col>-->
<!--        <v-col-->
<!--            sm="8">-->
<!--            <v-file-input-->
<!--                chips-->
<!--                dense-->
<!--                multiple-->
<!--                label="Загрузить документ"-->
<!--            ></v-file-input>-->
<!--        </v-col>-->
<!--        <v-col sm="2">-->
<!--            <comment></comment>-->
<!--        </v-col>-->
<!--    </v-row>-->

<!--        <template v-slot:title>-->
<!--            Прикрепить файл-->
<!--        </template>-->
        <v-card>
            <v-toolbar height="50" elevation="1">
                <span>
                    <v-icon>mdi-card-bulleted-outline</v-icon>
                    Прикрепить файлы
                </span>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                    <v-btn icon color="error" @click="close">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-toolbar-items>
            </v-toolbar>


        </v-card>
    </v-dialog>


</template>

<script>
import Comment from "./Comment";
import BaseDatePicker from "gird-base-front/src/components/BaseDatePicker";


export default {
    component: {Comment, BaseDatePicker},
    data(){
        return {
            dialog: this.value,
        }

    },
}
</script>
