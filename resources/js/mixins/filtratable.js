export default {
    data () {
        return {
            meta: {},
            filters: { },
            debounced: null,
            options: {
                page: 1,
                itemsPerPage: 50
            },
            loading: false,
        }
    },
    watch: {
        filters: {
            handler() {
                this.filter();
            },
            deep: true
        },
        options: {
            handler() {
                this.fetchDebounced();
            },
            deep: true
        },
    },
    computed: {
        params() {
            return Object.assign({}, this.options, this.filters);
        }
    },
    methods: {
        filter() {
            if(this.options.page !== 1)
                this.options.page = 1;
            else
                this.fetchDebounced();
        },
        setDebounce(func, interval = 300) {
            this.debounced = _.debounce(func, interval);
        },
        fetchDebounced() {
            if(this.debounced) {
                this.debounced();
            }

        }
    },
}
