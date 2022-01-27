<!--Перенаправить документ виновной стороне-->
<template>
    <v-dialog
        :value="value"
        width="400"
        scrollable
        persistent>

    <v-card>
        <v-toolbar height="50" elevation="1">
                <span>
                    <v-icon>mdi-shuffle-disabled</v-icon>
                   Перенаправить доккументы
                </span>
            <v-spacer></v-spacer>
            <v-toolbar-items>
                <v-btn icon color="error" @click="close">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-toolbar-items>
        </v-toolbar>
        <v-card-title >
            <v-row >
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
                <v-col sm="2">  <comment ></comment></v-col>
                <v-col sm="10">
                    <v-card-actions>
                        <v-row>
                            <v-col
                                v-for="(item, i) in items"
                                :key="i"
                                sm="10">
                                <v-card>
                                    <v-card-actions>
                                        {{ item.name }}
                                        <v-spacer></v-spacer>
                                        <v-btn icon align="end">
                                            <v-icon small color="red">mdi-bucket</v-icon>
                                        </v-btn>
                                    </v-card-actions>

                                </v-card>
                            </v-col>
                        </v-row>

                    </v-card-actions>
                </v-col>
            </v-row>
        </v-card-title>

        <comp-save-cancel></comp-save-cancel>

    </v-card>
    </v-dialog>




</template>

<script>

import BaseDatePicker from "gird-base-front/src/components/BaseDatePicker";
import Comment from "./Comment";
import CompSaveCancel from "./CompSaveCancel";

export default {
    components: {BaseDatePicker, Comment,CompSaveCancel},
    name: "SendFile",
    props: {
        value: {
            type: Boolean,
            required: true,
        },
    },
    data() {
        return {
            Calendar: null,
            date: new Date().toISOString().substr(0, 10),
            fileInput: 'file',
            items: [
                {
                    name: 'name1',
                },
                {
                    name: 'name2',
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
