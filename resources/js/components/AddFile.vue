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
        <v-card-title>
            <v-row>
                <v-col
                    sm="10">
            <v-file-input
                chips
                dense
                multiple
                label="Прикрепить документ"
            ></v-file-input>
                </v-col>

        <v-card-actions>
            <v-row justify="center">
                <v-col
                    v-for="(item, i) in items"
                    :key="i"
                    sm="10">
                    <v-card width="300">
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
            </v-row>
        </v-card-title>


    </v-card>
    </v-dialog>

</template>
<script>

export default {
    name: "AddFile",
    props: {
        value: {
            type: Boolean,
            required: true,
        },
    },
    data() {
        return {
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
