const app = window.Vue.createApp({
	data() {
		return {
			routes: {
				form: true,
				result: false,
			},
			text: "",
			rows: [],
		};
	},
	methods: {
		onSubmitForm(data) {
			this.text = data.text;
			this.rows = data.result;

			this.routes.form = false;
			this.routes.result = true;
		},

		backToMain() {
			this.routes.form = true;
			this.routes.result = false;

			this.text = "";
			this.rows = [];
		},
	},
});

app.component("output-result", OutputResult);
app.component("submit-form", SubmitForm);

app.mount("#main");