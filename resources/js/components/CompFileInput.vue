<!--Прикрепить файл-->
<template>
    <v-dialog
        :value="value"
        width="300"
        scrollable
        persistent
    >
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
