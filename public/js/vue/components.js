const SubmitForm = {
	template: `
		<div class="container mt-5" style="max-width: 600px;">
			<form @submit.prevent="handleSubmitForm">
				<div class="mb-3">
					<label for="textInput" class="form-label fw-semibold">Text</label>
					<textarea
						name="text"
						class="form-control"
						id="textInput"
						rows="5"
						placeholder="Please Enter Text"
						style="resize: vertical;"
						:value="text"></textarea>
				</div>

				<button type="submit" class="btn w-100 text-white" style="background-color:#61c7e9;">
					Submit
				</button>
			</form>
		</div>
	`,
	props: {
		text: {
			type: String,
			required: true,
		},
	},
	methods: {
		handleSubmitForm(e) {
			const formData = new FormData(e.currentTarget);

			return axios.post("/ajax/sendWords", formData).then((response) => {
				this.$emit("form", response.data);
			});
		},
	},
};

const OutputResult = {
	template: `
		<div class="container mt-4">
			<div class="d-flex justify-content-between align-items-center mb-2">
				<h6 class="mb-0">You submitted text:</h6>

				<button type="button" class="btn btn-info text-white btn-sm" @click="$emit('back')">
					Submit another text
				</button>
			</div>

			<div class="card mb-4">
				<textarea
					name="text"
					class="form-control"
					id="textInput"
					rows="5"
					placeholder="Please Enter Text"
					style="resize: vertical;"
					disabled
					:value="text"></textarea>
			</div>

			<table class="table table-bordered table-hover">
				<thead class="table-light">
					<tr>
						<th>#</th>
						<th>Word</th>
						<th>Count</th>
						<th>Stars</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="row, index in rows">
						<td>{{index+1}}</td>
						<td>{{row['word']}}</td>
						<td>{{row['count']}}</td>
						<td>{{rowStars(index)}}</td>
					</tr>
				</tbody>
			</table>
		</div>
	`,
	props: {
		rows: {
			type: Array,
			required: true,
		},
		text: {
			type: String,
			required: true,
		},
	},
	methods: {
		rowStars(index) {
			return (2 - index) >= 0 ? '*'.repeat(3 - index) : "-";
		},
	},
};
