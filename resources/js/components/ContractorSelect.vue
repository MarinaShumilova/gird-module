<template>
    <div>
        <!--TODO::placeholder сделать через локализацию-->
        <v-autocomplete
            :loading="loading"
            ref="autocomplete"
            :readonly="isContractorSelected"
            v-model="selected"
            v-bind="$attrs"
            placeholder="Введите ИНН или название"
            :search-input.sync="search"
            :items="contractors"
            item-value="id"
            item-text="name_with_inn"
            :append-icon="Boolean(selected) ? 'mdi-close' : '$dropdown'"
            @click:append="clearSelected"
        >
            <template v-slot:selection="{item}">
                {{item.name_with_inn}}
            </template>

            <template v-slot:item="{item}">
                <v-list-item-content >
                    <v-list-item-title>
                        {{ item.name_with_inn }}
                        <v-icon v-if="item.blacklist" class="ml-2" color="error" small>
                            mdi-alert-box-outline
                        </v-icon>
                    </v-list-item-title>
                </v-list-item-content>
            </template>
        </v-autocomplete>
    </div>
</template>

<script>

//import {ContractorService} from '../../services/contractor.service'

export default {
    name: "ContractorSelect",
    props: {
        value: {
            required: true
        },
        items: {
            type: Array,
            default: () => {
                return [];
            }
        }
    },
    created() {
        this.debouncedGetContractors = _.debounce(this.getContractors, 300);
    },
    data() {
        return {
            search: null,
            contractors: this.items,
            selected: this.value,
            loading: false,
            menu: {
                show: false,
                x: 0,
                y: 0
            },
            debouncedGetContractors: null

        }
    },
    computed: {
        isContractorSelected() {
            return Boolean(this.selected);
        }
    },
    watch: {
         value: {
             handler(value) {
                 if(this.selected !== value)
                     this.selected = value;
             },
             deep: true
         },
        selected(value) {
            this.$emit('input', value);
        },
        search(value) {

            this.debouncedGetContractors();

        },
    },
    methods: {
        getContractors() {
            if(this.search && this.search.length >= 3) {
                this.loading = true;

                api.call(endpoint('complaints.contractors', {search: this.search}))
                    .then(({data}) => {
                        this.contractors = data;

                    }).finally(() => {

                    this.loading = false;
                });
            }
        },
        clearSelected() {
            this.selected = null;
            this.contractors = [];
            this.$refs.autocomplete.focus();
        }
    }
}
</script>

<style scoped>

</style>
