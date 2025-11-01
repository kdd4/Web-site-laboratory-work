<script setup></script>

<template>
	<main>
		<h2>Тест по высшей математике</h2>
		<form
			id="testForm"
			action="mailto:daniilkamyshov2004@yandex.ru"
			method="Post"
			enctype="text/plain"
		>
			<div id="q1Div">
				<h3>1-й вопрос</h3>
				<p>Введите значение натурального логарифма с точностью до десятых</p>
				<label>Ответ:</label>
				<input type="text" name="question1" placeholder="Введите ответ" />
			</div>
			<div id="q2Div">
				<h3>2-й вопрос</h3>
				<p>Чему равен якобиан преобразования к сферическим координатам</p>
				<div class="noflex">
					<label>Варианты:</label>
					<label class="radioLabel">r<sup>2</sup>sin &#952;</label>
					<input type="radio" name="question2" value="r2 sin tetta" />
					<label class="radioLabel">r<sup>2</sup>cos &#952;</label>
					<input type="radio" name="question2" value="r2 cos tetta" />
				</div>
			</div>
			<div id="q3Div">
				<h3>3-й вопрос</h3>
				<p>Определитель не изменится, если:</p>
				<label>Ответ:</label>
				<select name="question3">
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
		<div id="errorValues" class="invisible">
			<p>Ответ(ы) не выбраны или введены не в правильном формате</p>
		</div>
		<div id="testGoodResult" class="invisible">
			<p>Всё верно</p>
		</div>
		<div id="testBadResult" class="invisible">
			<p>Есть ошибки</p>
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
