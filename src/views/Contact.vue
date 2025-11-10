<script setup>
import { ref, watch, watchEffect } from 'vue';
import Form from '@/components/Form.vue';

const showError = ref(false);
const allowSubmit = ref(false);

// form fields
const fio = ref('');
const gender = ref('');
const age = ref('');
const email = ref('');
const number = ref('');
const birthday = ref(new Date(Date.now()));

// Show error on field
const fioWrong = ref(false);
const genderWrong = ref(false);
const ageWrong = ref(false);
const emailWrong = ref(false);
const numberWrong = ref(false);
const birthdayWrong = ref(false);

// Show correct on field
const fioCorrect = ref(false);
const genderCorrect = ref(false);
const ageCorrect = ref(false);
const emailCorrect = ref(false);
const numberCorrect = ref(false);
const birthdayCorrect = ref(false);

// Error state for allowing submit
const IsFIOWrong = ref(true);
const IsGenderWrong = ref(true);
const IsAgeWrong = ref(true);
const IsEmailWrong = ref(true);
const IsNumberWrong = ref(true);
const IsBirthdayWrong = ref(true);

function checkFIO() {
	let fio_re = /^[а-яёА-ЯЁa-zA-Z]+ [а-яёА-ЯЁa-zA-Z]+ [а-яёА-ЯЁa-zA-Z]+$/;

	// Update on field
	fioWrong.value = !fio_re.test(fio.value);
	fioCorrect.value = !fioWrong.value;

	// Update error state for allowing submit
	IsFIOWrong.value = fioWrong.value;
}

function checkGender() {
	// Update on field
	genderWrong.value = !gender.value;
	genderCorrect.value = !genderWrong.value;

	// Update error state for allowing submit
	IsGenderWrong.value = genderWrong.value;
}

function checkAge() {
	// Update on field
	ageWrong.value = !age.value;
	ageCorrect.value = !ageWrong.value;

	// Update error state for allowing submit
	IsAgeWrong.value = ageWrong.value;
}

function checkEmail() {
	let email_re = /^\w+@\w+.\w{2,}$/;

	// Update on field
	emailWrong.value = !email_re.test(email.value);
	emailCorrect.value = !emailWrong.value;

	// Update error state for allowing submit
	IsEmailWrong.value = emailWrong.value;
}

function checkNumber() {
	let number_re = /^\+7|3\d{8,10}$/;

	// Update on field
	numberWrong.value = !number_re.test(number.value);
	numberCorrect.value = !numberWrong.value;

	// Update error state for allowing submit
	IsNumberWrong.value = numberWrong.value;
}

function checkBirthday() {
	// Update on field
	birthdayWrong.value = birthday.value.getTime() > Date.now();
	birthdayCorrect.value = !birthdayWrong.value;

	// Update error state for allowing submit
	IsBirthdayWrong.value = birthdayWrong.value;
}

function updateAllowSubmit() {
	allowSubmit.value = !(
		IsFIOWrong.value ||
		IsGenderWrong.value ||
		IsAgeWrong.value ||
		IsEmailWrong.value ||
		IsNumberWrong.value ||
		IsBirthdayWrong.value
	);
}

function updateShowError() {
	showError.value =
		fioWrong.value ||
		genderWrong.value ||
		ageWrong.value ||
		emailWrong.value ||
		numberWrong.value ||
		birthdayWrong.value;
}

watch(fio, checkFIO);
watch(gender, checkGender);
watch(age, checkAge);
watch(email, checkEmail);
watch(number, checkNumber);
watch(birthday, checkBirthday, { deep: true });
watchEffect(updateAllowSubmit);
watchEffect(updateShowError);

function formSubmit(event) {
	let form = document.getElementById('form');

	fetch('/api', {
		method: 'POST',
		body: new FormData(form),
	});
}

const formdata = {
	allowSubmit: allowSubmit,
};

const formfields = ref([
	{
		label: 'ФИО',
		type: 'text',
		name: 'FIO',
		placeholder: 'Введите ФИО',
		var_ref: fio,
		wrongValue_ref: fioWrong,
		correctValue_ref: fioCorrect,
	},
	{
		label: 'Пол',
		type: 'radio',
		name: 'gender',
		options: [
			{ text: 'M', value: 'Male' },
			{ text: 'Ж', value: 'Female' },
		],
		var_ref: gender,
		wrongValue_ref: genderWrong,
		correctValue_ref: genderCorrect,
	},
	{
		label: 'Возраст',
		type: 'select',
		name: 'age',
		options: [
			{ value: '', text: 'Выберите', disabled: true },
			{ value: 'less16', text: 'До 16', disabled: false },
			{ value: '16-18', text: '16-18', disabled: false },
			{ value: 'more18', text: 'Старше 18', disabled: false },
		],
		var_ref: age,
		wrongValue_ref: ageWrong,
		correctValue_ref: ageCorrect,
	},
	{
		label: 'E-mail',
		type: 'text',
		name: 'email',
		placeholder: 'Введите E-mail',
		var_ref: email,
		wrongValue_ref: emailWrong,
		correctValue_ref: emailCorrect,
	},
	{
		label: 'Номер',
		type: 'text',
		name: 'number',
		placeholder: 'Введите номер',
		var_ref: number,
		wrongValue_ref: numberWrong,
		correctValue_ref: numberCorrect,
	},
	{
		label: 'День рождения',
		type: 'date',
		name: 'birthday',
		var_ref: birthday,
		wrongValue_ref: birthdayWrong,
		correctValue_ref: birthdayCorrect,
	},
]);
</script>

<template>
	<main class="flex flex-col items-center justify-center space-y-3">
		<h2 class="mb-8 text-center text-2xl font-bold not-md:text-xl">Контакт</h2>
		<Form id="form" :fields="formfields" :formdata="formdata" @submit="formSubmit" />
		<div
			v-show="showError"
			class="rounded-sm border-2 border-red-500/30 bg-red-400 p-0.5 text-center"
		>
			<p>Неправильно введены данные</p>
		</div>
	</main>
</template>
