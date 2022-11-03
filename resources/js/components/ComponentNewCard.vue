<template>
    <v-dialog
        :value="value"
        max-width="800px"
        scrollable
        persistent
    >
        <v-card>
            <v-card-title>Заголовок
                <v-spacer></v-spacer>
                <v-btn icon color="error" @click="close">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <add-card></add-card>
            </v-card-text>
        </v-card>

    </v-dialog>
</template>
<script>

import AddCard from "./AddCard";
export default {
    components: {AddCard},
    props: {
        value: {
            type: Boolean,
            required: true,
        },
    },
    data () {
        return {
            myValue: null,
        }
    },
    methods: {
        close() {
            this.$emit('input', false);
        }
    }
}
</script>
<style scoped>

</style>
