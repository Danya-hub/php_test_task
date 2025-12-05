<section id="main">
	<submit-form v-show="routes.form" v-clock @form="onSubmitForm" :text="text"></submit-form>
	<output-result v-show="routes.result" v-clock :rows="rows" :text="text" @back="backToMain"></output-result>
</section>