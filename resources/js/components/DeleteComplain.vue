<!--Затраты-->
<template>
    <v-dialog
        :value="value"
        width="400"
        scrollable
        persistent>
        <v-card>
            <v-card-title class="text-h5">
                Действительно хотите удалить?</v-card-title>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="close">Отмена</v-btn>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="confirm">Удалить</v-btn>
                <v-spacer></v-spacer>
            </v-card-actions>
        </v-card>


    </v-dialog>


</template>
<script>


export default {
    name: "DeleteComplain",
    props: {
        value: {
            type: Boolean,
            required: true,
        },
    },

    data() {
        return {
            dialog: this.value
        }
    },
    watch: {
        dialog(value) {
            this.$emit('input', value);
        }
    },
        methods: {
            close() {
                this.dialog = false;
            },
            confirm() {
                this.$emit('confirmed');
            }
        },

}

</script>
