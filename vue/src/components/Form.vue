<script setup>
defineProps({
    title: {
        type: String,
        default: 'New Data'
    },
    url: String,
    update: Boolean,
    forms: {
        type: Object,
        default: () => ({
            'id': {
                label: 'ID',
                type: 'text',
                hidden: true,
                value: ''
            },
            'name': {
                label: 'Name',
                type: 'text',
                hidden: false,
                value: ''
            },
            'email': {
                label: 'Email',
                type: 'email',
                hidden: false,
                value: ''
            },
            'dateof': {
                label: 'Date',
                type: 'date',
                hidden: false,
                value: ''
            },
            'selection': {
                label: 'Selection',
                type: 'select',
                hidden: false,
                value: '',
                options: [
                    { value: '1', text: 'One' },
                    { value: '2', text: 'Two' },
                    { value: '3', text: 'Three' },
                ]
            },
        })
    },
})
</script>
<template>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title">
                    <i class="bi" :class="(update) ? 'bi-pencil-square' : 'bi-plus-square'"></i>
                    {{ update ? 'Edit' : 'New' }} Data
                </h5>
            </div>
            <form autocomplete="off" @submit.prevent="submitChild" @reset.prevent="cancelChild">
                <div class="vstack gap-2">
                    <!-- add d-none if hidden -->
                    <div v-for="(form, key) in forms" :key="key" :class="{ 'd-none': form.hidden }">
                        <label :for="key" class="form-label">{{ form.label }}</label>
                        <textarea v-if="form.type == 'textarea'" class="form-control" :id="key" v-model="form.value" rows="3" required></textarea>
                        <select v-else-if="form.type == 'select'" class="form-select" :id="key" v-model="form.value" required>
                            <option v-for="(option, key) in form.options" :key="key" :value="option.value">{{ option.text }}</option>
                        </select>
                        <input v-else-if="form.type == 'number'" type="number" class="form-control" :id="key" v-model="form.value" required @keypress="filterNumber($event)" />
                        <input v-else :type="form.type" class="form-control" :id="key" v-model="form.value" :required="!form.hidden" />
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="reset" class="btn btn-sm btn-danger mt-3 align-self-end">
                        <i class="bi bi-x"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-sm mt-3 align-self-end" :class="(update) ? 'btn-primary' : 'btn-success'">
                        <i class="bi" :class="(update) ? 'bi-pencil' : 'bi-plus'"></i> {{ update ? 'Edit' : 'Submit' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
//create v-model for each form
export default {
    methods: {
        submitChild() {
            console.log('submit')
            //reformat form to key:value
            let data = {}
            for (const [key, value] of Object.entries(this.forms)) {
                data[key] = value.value
            }

            this.$emit('submitChild', data)
        },
        cancelChild() {
            this.$emit('cancelChild')
        },
        //filter number into to only number
        filterNumber(e) {
            if (e.key.match(/[^0-9]/g)) {
                e.preventDefault();
            }
        }
    },
    watch: {
        //apply changes to forms
        forms: {
            handler() {
                this.$emit('update:forms', this.forms)
            },
            deep: true
        },
    }
}
</script>

<style scoped>
.hstack div {
    width: 100%;
}
</style>