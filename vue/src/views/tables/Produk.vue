<script setup>
import { TabulatorFull as Tabulator } from 'tabulator-tables';
import Form from '../../components/Form.vue'
</script>
<template>
    <div class="row row-cols-1">
        <div class="col col-md-9 mb-md-0 ">
            <div class="vstack gap-2">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="fs-5">
                                <i class="bi bi-tools"></i> Toolbar
                            </div>
                            <select class="form-select w-25" v-model="displayWhich" @change="getDataProxy">
                                <option value="1">Bisa Dijual</option>
                                <option value="2">Tidak Bisa Dijual</option>
                                <option value="3">Semua</option>
                            </select>
                            <div class="hstack gap-2">
                                <button class="btn btn-primary btn-sm" @click="getDataProxy">
                                    <i class="bi bi-arrow-clockwise"></i> Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="fs-5">
                                <i class="bi bi-grid"></i> Data Table - {{ displayWhich == 1 ? 'Bisa Dijual' : displayWhich == 2 ? 'Tidak Bisa Dijual' : 'Semua'  }}
                            </div>
                            <div class="spinner-border spinner-border-sm" role="status" :class="{ 'd-none': tableLoaded }">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <div ref="table">

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col col-md-3">
            <div class="vstack gap-2">
                <Form :update="update" :forms="xforms" @cancelChild="cancelEdit" @submitChild="modify" />
            </div>
        </div>
    </div>
</template>
<script>
import tableMixin from '../../mixins/tableMixin.js'

export default {
    data() {
        return {
            tabulator: null, //variable to hold your table
            tableData: [], //data for table to display
            xforms: {
                'id': {
                    label: 'ID',
                    type: 'text',
                    hidden: true,
                    value: ''
                },
                'nama': {
                    label: 'Nama',
                    type: 'textarea',
                    hidden: false,
                    value: ''
                },
                'harga': {
                    label: 'Harga',
                    type: 'number',
                    hidden: false,
                    value: ''
                },
                'kategori_id': {
                    label: 'Kategori',
                    type: 'select',
                    hidden: false,
                    value: '',
                    options: [
                        { value: '1', text: 'One' },
                        { value: '2', text: 'Two' },
                        { value: '3', text: 'Three' },
                    ]
                },
                'status_id': {
                    label: 'Status',
                    type: 'select',
                    hidden: false,
                    value: '',
                    options: [
                        { value: '1', text: 'One' },
                        { value: '2', text: 'Two' },
                        { value: '3', text: 'Three' },
                    ]
                },
            },
            update: false,
            tableMessage: 'Loading...',
            tableLoaded: false,
            url: 'api/v1/produk/',
            displayWhich: 1,
        }
    },
    async mounted() {
        await this.getSelect()
        //instantiate Tabulator when element is mounted
        this.tabulator = new Tabulator(this.$refs.table, {
            layout: "fitColumns",      //fit columns to width of table
            data: this.tableData, //link data to table
            pagination: "local",
            paginationSize: 10,
            paginationCounter: "rows",
            columns: [
                { title: "ID", field: "id", width: 75 },
                { title: "Name", field: "nama", hozAlign: "left", formatter: "textarea", width: 300 },
                { title: "Harga", field: "harga", hozAlign: "left" },
                { title: "Kategori", field: "nama_kategori", hozAlign: "left" },
                //button to call testedit
                {
                    title: "Action",
                    width: 100,
                    download: false,
                    formatter: () => {
                        return `
                            <div class="d-flex justify-content-between align-items-center">
                                <button class="btn btn-sm btn-outline-primary" id="tb-edit"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-sm btn-outline-danger" id="tb-del"><i class="bi bi-trash"></i></button>
                            </div>
                        `;
                    },
                    cellClick: (e, cell) => {
                        //check which is clicked and the icon too
                        if (e.target.id == 'tb-edit' || e.target.parentElement.id == 'tb-edit') {
                            this.editData(cell.getRow().getData());
                        } else if (e.target.id == 'tb-del' || e.target.parentElement.id == 'tb-del') {
                            this.deleteData(cell.getRow().getData().id);
                        }
                    },
                },
            ], //define table columns
        });

        this.getData(true, {
            'displayWhich': this.displayWhich
        });
    },
    methods: {
        async getSelect() {
            const kategori = await this.$http.get(this.$SERVER + 'api/v1/kategori/')
            const status = await this.$http.get(this.$SERVER + 'api/v1/status/')
            this.xforms.kategori_id.options = kategori.data.data.map((item) => {
                return {
                    value: item.id,
                    text: item.nama
                }
            })

            this.xforms.status_id.options = status.data.data.map((item) => {
                return {
                    value: item.id,
                    text: item.nama
                }
            })
        },
        async getDataProxy() {
            this.getData(false, {
                'displayWhich': this.displayWhich
            })
        },
        async modify(data) {
            try {
                if (this.update) {
                    await this.$http.put(
                        this.$SERVER + this.url + data.id + '/',
                        data,
                    ).then((response) => {
                        //remove from table
                        this.$emit('callFoot', response.data.message, 'bg-primary');
                        this.getDataProxy();
                    });
                }
                else {
                    //remove id
                    delete data.id;
                    await this.$http.post(
                        this.$SERVER + this.url,
                        data,
                    ).then((response) => {
                        //remove from table
                        this.$emit('callFoot', response.data.message, 'bg-primary');
                        this.getDataProxy();
                    });
                }
            } catch (error) {
                this.httpError(error)
            }
        },
        async deleteData(id) {
            if (confirm('Are you sure?')) {
                try {
                    await this.$http.delete(
                        this.$SERVER + this.url + id + '/',
                        { data: { id: id } }
                    ).then((response) => {
                        //remove from table
                        this.$emit('callFoot', response.data.message, 'bg-primary');
                        this.getDataProxy();
                    });
                } catch (error) {
                    this.httpError(error)
                }
            }
        },
    },

    created() {
        this.httpError = tableMixin.httpError.bind(this)
        this.cancelEdit = tableMixin.cancelEdit.bind(this)
        this.editData = tableMixin.editData.bind(this)
        //this.deleteData = tableMixin.deleteData.bind(this)
        //this.modify = tableMixin.modify.bind(this)
        this.getData = tableMixin.getData.bind(this)
    },
}
</script>