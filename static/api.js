const app = Vue.createApp({
	data() {
		return {
			 statuses: [],
			 data: [],
			 filterData: [],
			 tableTitle: [],
			 search: '',
			 loaded: false
			}
	},
	methods: {
		initData() {
			axios.post('./api.php', {method: 'Status'}).then((response) => {
				this.statuses = response.data;
			});
			axios.post('./api.php', {method: 'header'}).then((response) => {
				this.tableTitle = response.data;
				// console.log(this.tableTitle);
				return axios.post('./api.php', {method: 'allData'});
			}).then((response) => {
				this.data = response.data;
				this.filterData = response.data;
				// console.log(this.data);
				this.loaded = true;
			});
		},

		filter(status) {
			console.log(status);
			// this.search = '';
			if(status) {
				this.filterData = this.data.filter((item) => {
				return item['Status'] == status;
				});
			} else {
				this.filterData = this.data;
			}
		},

		searchFood(search) {
			console.log(search);
			if(search) {
				this.filterData = this.data.filter((item) => {
					return item['FoodItems'].toLowerCase().includes(search.trim().toLowerCase());
				});
			} else {
				this.filterData = this.data;
			}
		},

		searchBEFood(search) {
			console.log(search);
			axios.post('./api.php', {method: 'filterData', filter: search}).then((response) => {
				this.data = response.data;
				this.filterData = response.data;
			});
		}
	}
})

const vm = app.mount('#food');
vm.initData();