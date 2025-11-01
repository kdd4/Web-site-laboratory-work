<script setup>
import { ref, watch, watchEffect } from 'vue'

const showError = ref(false)
const allowSubmit = ref(false)

// form fields
const fio = ref('')
const gender = ref('')
const age = ref('')
const email = ref('')
const number = ref('')

// Error on screen
const fioWrong = ref(false)
const genderWrong = ref(false)
const ageWrong = ref(false)
const emailWrong = ref(false)
const numberWrong = ref(false)

// Error for checking
const IsFIOWrong = ref(true)
const IsGenderWrong = ref(true)
const IsAgeWrong = ref(true)
const IsEmailWrong = ref(true)
const IsNumberWrong = ref(true)

function checkFIO() {
	let fio_re = /^[а-яёА-ЯЁa-zA-Z]+ [а-яёА-ЯЁa-zA-Z]+ [а-яёА-ЯЁa-zA-Z]+$/

	fioWrong.value = !fio_re.test(fio.value) // Update on screen
	IsFIOWrong.value = fioWrong.value // Update for checking
}

function checkGender() {
	genderWrong.value = !gender.value // Update on screen
	IsGenderWrong.value = genderWrong.value // Update for checking
}

function checkAge() {
	ageWrong.value = !age.value // Update on screen
	IsAgeWrong.value = ageWrong.value // Update for checking
}

function checkEmail() {
	let email_re = /^\w+@\w+.\w{2,}$/

	emailWrong.value = !email_re.test(email.value) // Update on screen
	IsEmailWrong.value = emailWrong.value // Update for checking
}

function checkNumber() {
	let number_re = /^\+7|3\d{8,10}$/

	numberWrong.value = !number_re.test(number.value) // Update on screen
	IsNumberWrong.value = numberWrong.value // Update for checking
}

function updateAllowSubmit() {
	allowSubmit.value = !(
		IsFIOWrong.value ||
		IsGenderWrong.value ||
		IsAgeWrong.value ||
		IsEmailWrong.value ||
		IsNumberWrong.value
	)
}

function updateShowError() {
	showError.value =
		fioWrong.value || genderWrong.value || ageWrong.value || emailWrong.value || numberWrong.value
}

watch(fio, checkFIO)
watch(gender, checkGender)
watch(age, checkAge)
watch(email, checkEmail)
watch(number, checkNumber)
watchEffect(updateAllowSubmit)
watchEffect(updateShowError)
</script>

<template>
	<main>
		<form
			id="contactForm"
			action="mailto:daniilkamyshov2004@yandex.ru"
			method="Post"
			enctype="text/plain"
		>
			<div id="inputFIO" :class="{ wrongValue: fioWrong }">
				<label>ФИО:</label>
				<input type="text" name="FIO" placeholder="Введите ФИО" v-model.trim.lazy="fio" />
			</div>
			<div id="inputGender" :class="{ wrongValue: genderWrong }">
				<label>Пол:</label>
				<label class="radioLabel">М</label>
				<input type="radio" name="gender" value="Male" v-model.lazy="gender" />
				<label class="radioLabel">Ж</label>
				<input type="radio" name="gender" value="Female" v-model.lazy="gender" />
			</div>
			<div id="inputAge" :class="{ wrongValue: ageWrong }">
				<label>Возраст:</label>
				<select name="age" v-model.lazy="age">
					<option disabled value="">Выберите</option>
					<option value="less16">До 16</option>
					<option value="16-18">16-18</option>
					<option value="more18">Старше 18</option>
				</select>
			</div>
			<div id="inputEmail" :class="{ wrongValue: emailWrong }">
				<label>E-mail:</label>
				<input type="email" name="email" placeholder="Введите E-mail" v-model.trim.lazy="email" />
			</div>
			<div id="inputNumber" :class="{ wrongValue: numberWrong }">
				<label>Номер:</label>
				<input
					type="text"
					name="number"
					placeholder="Введите номер телефона"
					v-model.trim.lazy="number"
				/>
			</div>
			<input :disabled="!allowSubmit" type="submit" />
		</form>
		<div id="errorDiv" :class="{ invisible: !showError }">
			<p>Неправильно введены данные</p>
		</div>
	</main>
</template>

<style scoped>
main {
	--form_color: gainsboro;
	--nav_button_text_color: black;
	--error_color: #cc3333;
}

.invisible {
	display: none;
}

main {
	display: flex;
	justify-content: center;
	flex-direction: column;
	align-items: center;
}

form {
	display: flex;
	flex-direction: column;
	justify-content: left;

	padding: 1em;
	background-color: var(--form_color);
	border-radius: 5%;
}

form div {
	margin: 0.5em;
	padding: 2px;
}

.radioLabel {
	padding-left: 1em;
}

div label:nth-child(1) {
	padding: 0;
}

input[type='submit'] {
	margin: 1em 0em 0em 0em;
	align-self: center;
}

.wrongValue {
	border-radius: 5%;
	padding: 2px;
	background-color: var(--error_color);
}

#errorDiv {
	padding: 0.1em 1em 0.1em 1em;
	margin: 1em;
	background-color: var(--error_color);
	border-radius: 5%;
}
</style>
