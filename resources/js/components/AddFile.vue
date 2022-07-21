<template>
    <v-dialog
        :value="value"
        width="400"
        scrollable
        persistent>
    <v-card>
        <v-toolbar height="50" elevation="0">
                <span>
                    <v-icon>mdi-folder-multiple-plus</v-icon>
                   Прикрепить документы
                </span>
            <v-spacer></v-spacer>
            <v-toolbar-items>

                <v-btn icon color="error" @click="close">
                    <v-icon>mdi-close</v-icon>
                </v-btn>

            </v-toolbar-items>
        </v-toolbar>
        <v-card-text>
            <v-row justify="center">
                <v-col
                    sm="10">
                    <base-file-input
                        v-model="files"
                        :extensions="extensions"
                        lable = "Прикрепить документы"
                        :max-size="maxSize"
                    ></base-file-input>
                </v-col>
                <v-col
                    sm="10">
                <v-list>
                    <v-list-item
                        v-for="item in files"
                        :key="item.id"
                    >
                        <v-list-item-title>{{ item.name }}
                            <v-divider></v-divider>
                        </v-list-item-title>

                        <v-btn icon

                        >
                            <v-icon small color="red">mdi-bucket</v-icon>
                        </v-btn>
                    </v-list-item>
                </v-list>
                    <v-divider></v-divider>
                </v-col>

            </v-row>

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
                    Добавить
                </v-btn>
            </v-card-actions>
        </v-card-text>


    </v-card>
    </v-dialog>

</template>
<script>

import BaseFileInput from "gird-base-front/src/components/BaseFileInput";

export default {
    components:{BaseFileInput},
    name: "AddFile",
    props: {
        value: {
            type: Boolean,
            required: true,
        },
        loading: {
            type: Boolean,
            default: false
        },
    },
    data() {
        return {
            files:[],
            extensions:[],
            maxSize:'',
            items: [
                {
                    name: 'name1',
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
