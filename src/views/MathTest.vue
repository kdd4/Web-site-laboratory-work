<script setup>
import { computed, ref } from 'vue'

const showError = ref(false)
const showGood = ref(false)
const showBad = ref(false)

const messages = ref([
	{
		id: 'errorValues',
		text: 'Ответ(ы) не выбраны или введены не в правильном формате',
		show: showError,
	},
	{
		id: 'testGoodResult',
		text: 'Всё верно',
		show: showGood,
	},
	{
		id: 'testBadResult',
		text: 'Есть ошибки',
		show: showBad,
	},
])

// Current answers
const answer1 = ref('')
const answer2 = ref('')
const answer3 = ref('')

// Show error
const showWrongAnswer1 = ref(false)
const showWrongAnswer2 = ref(false)
const showWrongAnswer3 = ref(false)

// right answers
const rightAnswers = {
	answer1: 2.7,
	answer2: 'r2 sin tetta',
	answer3: 'var1',
}

// Is answers has wrong value
const wrongAnswer1 = computed(() => !answer1.value || isNaN(answer1.value - 0))
const wrongAnswer2 = computed(() => !answer2.value)
const wrongAnswer3 = computed(() => !answer3.value)

// Is correct current answer
const correctAnswer1 = computed(
	() => !wrongAnswer1.value && answer1.value - rightAnswers.answer1 <= 0.1,
)
const correctAnswer2 = computed(() => !wrongAnswer2.value && answer2.value == rightAnswers.answer2)
const correctAnswer3 = computed(() => !wrongAnswer3.value && answer3.value == rightAnswers.answer3)

// Result of test
const wrongAnswers = computed(() => wrongAnswer1.value || wrongAnswer2.value || wrongAnswer3.value)
const correctAnswers = computed(
	() => correctAnswer1.value && correctAnswer2.value && correctAnswer3.value,
)

function checkTest(event) {
	showWrongAnswer1.value = wrongAnswer1.value
	showWrongAnswer2.value = wrongAnswer2.value
	showWrongAnswer3.value = wrongAnswer3.value

	showError.value = wrongAnswers.value
	showGood.value = correctAnswers.value && !wrongAnswers.value
	showBad.value = !correctAnswers.value && !wrongAnswers.value
}

function resetTest(event) {
	showError.value = false
	showGood.value = false
	showBad.value = false

	showWrongAnswer1.value = false
	showWrongAnswer2.value = false
	showWrongAnswer3.value = false

	answer1.value = ''
	answer2.value = ''
	answer3.value = ''
}
</script>

<template>
	<main>
		<h2>Тест по высшей математике</h2>
		<form
			id="testForm"
			action=""
			method="Post"
			enctype="text/plain"
			@submit.prevent="checkTest"
			@reset.prevent="resetTest"
		>
			<div id="q1Div" :class="{ WrongValue: showWrongAnswer1 }">
				<h3>1-й вопрос</h3>
				<p>Введите значение натурального логарифма с точностью до десятых</p>
				<label>Ответ:</label>
				<input
					type="text"
					name="question1"
					placeholder="Введите ответ"
					v-model.trim.lazy="answer1"
				/>
			</div>
			<div id="q2Div" :class="{ WrongValue: showWrongAnswer2 }">
				<h3>2-й вопрос</h3>
				<p>Чему равен якобиан преобразования к сферическим координатам</p>
				<div class="noflex">
					<label>Варианты:</label>
					<label class="radioLabel">r<sup>2</sup>sin &#952;</label>
					<input type="radio" name="question2" value="r2 sin tetta" v-model="answer2" />
					<label class="radioLabel">r<sup>2</sup>cos &#952;</label>
					<input type="radio" name="question2" value="r2 cos tetta" v-model="answer2" />
				</div>
			</div>
			<div id="q3Div" :class="{ WrongValue: showWrongAnswer3 }">
				<h3>3-й вопрос</h3>
				<p>Определитель не изменится, если:</p>
				<label>Ответ:</label>
				<select name="question3" v-model="answer3">
					<option disabled value="">Выберете</option>
					<option value="var1">Переставить местами две строки</option>
					<option value="var2">
						Поделить элементы какой-нибудь строки (столбца) на их общий делитель
					</option>
					<option value="var3">Транспонировать матрицу</option>
				</select>
			</div>
			<div class="bottons">
				<input type="submit" />
				<input type="reset" />
			</div>
		</form>
		<div v-for="message in messages" :id="message.id" :class="{ invisible: !message.show }">
			<p>{{ message.text }}</p>
		</div>
	</main>
</template>

<style scoped>
main {
	--form_color: antiquewhite;
	--form_block_color: bisque;
	--error_color: #cc3333;
	--good_color: #33cc33;
}

main {
	display: flex;
	flex-direction: column;
	align-items: center;
}

form {
	background-color: var(--form_color);
	padding: 1.5em;
	margin: 1em;
	border-radius: 2%;
	width: 80%;
}

form div {
	display: flex;
	flex-direction: column;

	margin-bottom: 1em;
	padding: 1em;

	background-color: var(--form_block_color);
	border-radius: 2%;
}

.radioLabel {
	padding-left: 1em;
}

form div h3 {
	align-self: center;
}

.noflex {
	display: block;
}

.bottons {
	display: flex;
	flex-direction: row;
	justify-content: space-evenly;

	padding: 1em;
}

form div.WrongValue {
	background-color: var(--error_color);
}

form div.WrongValue div {
	background-color: var(--error_color);
}

#errorValues {
	margin: 1em;
	border-radius: 5%;
	padding: 0.3em;

	text-align: center;
	background-color: var(--error_color);
}

#testGoodResult {
	width: 50%;
	margin: 1em;
	border-radius: 5%;
	padding: 0.3em;

	text-align: center;
	background-color: var(--good_color);
}

#testBadResult {
	width: 50%;
	margin: 1em;
	border-radius: 5%;
	padding: 0.3em;

	text-align: center;
	background-color: var(--error_color);
}

.invisible {
	display: none;
}
</style>
