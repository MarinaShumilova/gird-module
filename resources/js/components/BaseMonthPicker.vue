<template>
    <v-menu
        v-model="menu"
        transition="scale-transition"
        offset-y
        min-width="290px"
        :close-on-content-click="false"
    >
        <template v-slot:activator="{ on, attrs }">
            <v-text-field
                :value="date"
                readonly
                v-bind="$attrs"

                v-on="on"
                @click:clear="clearDate"
            >

                <template v-for="(_, scopedSlotName) in $scopedSlots" v-slot:[scopedSlotName]="slotData">
                    <slot :name="scopedSlotName" v-bind="slotData" />
                </template>

                <template v-for="(_, slotName) in $slots" v-slot:[slotName]>
                    <slot :name="slotName" />
                </template>

            </v-text-field>
        </template>
        <v-date-picker
            v-model="date"
            @input="menu = false"
            v-bind="$attrs"
            :first-day-of-week="1"
        ></v-date-picker>
    </v-menu>
</template>

<script>
export default {
    name: "BaseDatePicker",
    props: {
        value: {
            type: String,
            default: new Date().toISOString().substr(0, 10)
        },
        /*errors: {
            type: Array,
            default: () => {
                return [];
            }
        }*/
    },
    data() {
        return {
            date: this.value,
            menu: false,
        }
    },
    watch: {
        date(value) {
            this.$emit('input', value);
        },
        value(value) {
            this.date = value;
        }
    },
    methods: {
        clearDate() {
            this.date = null;
        }
    }
}
</script>
