<!--Добавить новую запись-->
<template>
    <v-dialog
        :value="value"
        max-width="800"
        scrollable
        persistent>
        <v-card >
            <v-toolbar
                height="50">
                <v-toolbar-title>
                    <span>Добавить запись</span>
                </v-toolbar-title>
                <v-spacer></v-spacer>

                <v-toolbar-items>
                    <v-btn icon color="error" @click="close">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-toolbar-items>
            </v-toolbar>

            <!-- Компонент форма добавить запись -->
                <component-write></component-write>

                <CompSaveCancel
                    @Cancel="close"
                ></CompSaveCancel>
            <v-card-actions></v-card-actions>

        </v-card>

    </v-dialog>

</template>

<script>
//

import ComponentWrite from "./ComponentWrite";
import CompSaveCancel from "./CompSaveCancel"

export default {
    name: "AddCard",
    props: {
        value: {
            type: Boolean,
            required: true,
        },
    },
    components: {ComponentWrite, CompSaveCancel},
    data () {
        return{

        }


    },
    methods: {

        close() {
            this.$emit('input', false);
        },
        

    }




}



</script>

<style scoped>

</style>
