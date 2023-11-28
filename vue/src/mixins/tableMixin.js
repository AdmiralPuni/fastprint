export default {
    httpError: function(error) {
        if (error.response) {
            this.$emit('callFoot', error.message, 'bg-ni-se');
            console.log(error.message);
            console.log(error.response.data);
            console.log(error.response.status);
            console.log(error.response.headers);
        } else if (error.request) {
            this.$emit('callFoot', error.message + ' check your connection', 'bg-dark');
            console.log(error.message);
            console.log(error.request);
        } else {
            this.$emit('callFoot', error.message, 'bg-ni-se');
            console.log('Fatal Error');
            console.log('Error', error.message);
        }
    },
    cancelEdit: function() {
        this.update = false;
        for (const [key, value] of Object.entries(this.xforms)) {
            this.xforms[key].value = ''
        }
    },
    editData: function(data) {
        this.update = true;
        //console.log('changing data ' + id)
        for (const [key, value] of Object.entries(this.xforms)) {
            this.xforms[key].value = data[key]
        }
    },
    deleteData: async function(id) {
        if (confirm('Are you sure?')) {
            try {
                await this.$http.delete(
                    this.$SERVER + this.url + id + '/',
                    {data: {id: id}}
                ).then((response) => {
                    //remove from table
                    this.$emit('callFoot', response.data.message, 'bg-primary');
                    this.getData();
                });
            } catch (error) {
                this.httpError(error)
            }
        }
    },
    modify: async function (data) {
        //console.log('submitting data')
        //console.log(data)

        try {
            if(this.update){
                await this.$http.put(
                    this.$SERVER + this.url + data.id + '/',
                    data,
                ).then((response) => {
                    //remove from table
                    this.$emit('callFoot', response.data.message, 'bg-primary');
                    this.getData();
                });
            }
            else{
                //remove id
                delete data.id;
                await this.$http.post(
                    this.$SERVER + this.url,
                    data,
                ).then((response) => {
                    //remove from table
                    this.$emit('callFoot', response.data.message, 'bg-primary');
                    this.getData();
                });
            }
        } catch (error) {
            this.httpError(error)
        }
    },
    getData: async function(first = false, data = null) {
        try {
            this.tableMessage = 'Loading';
            this.tableLoaded = false;

            //clear table if data exists
            if(!first){
                this.tabulator.clearData();
            }

            await this.$http.get(
                this.$SERVER + this.url,
                {params: data}
            ).then((response) => {
                setTimeout(() => {
                    this.tableMessage = '';
                    this.tableLoaded = true;

                    var raw = response.data;

                    this.tableData = raw.data;
                    this.tabulator.setData(this.tableData);

                    //access ref in parent
                    this.$emit('callFoot', 'Data loaded', 'bg-success');
                }, 500);
            })
        } catch (error) {
            this.httpError(error)
        }
    }
}