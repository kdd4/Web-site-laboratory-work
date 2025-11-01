<script setup></script>

<template>
	<main>
		<p class="biograthy">
			Я родился в Анапе 27 декабря 2004 года. Учился в МБОУ СОШ № 4, где доучился до 11 класса. В 10
			и 11 классе становился призёром регионального этапа всероссийской олимпиды школьников по
			информатике и физике. ЕГЭ сдал суммарно на 243 балла и без проблем поступил в СевГУ.
			Участвовал в курсе математики от МФТИ. В 1 курсе занял 1 место на вузовской олимпиаде по
			высшей математике.
		</p>
		<img class="myPhoto" src="/src/assets/images/me.jpg" alt="Моя фотография" />
	</main>
</template>

<style scoped>
main {
	display: flex;
	justify-content: space-evenly;
}

.biograthy {
	font-size: large;

	max-width: 600px;
	min-width: 10em;

	margin: 20px auto;
	padding: 20px;
	text-align: justify;
	background: #f9f9f9;
	line-height: 1.6;
}

.myPhoto {
	max-width: 20em;
	min-width: 8em;

	height: 100%;
	width: 30%;
	padding: 20px;
}

@media (max-width: 600px) {
	main {
		flex-direction: column;
		align-items: center;
	}

	.myPhoto {
		width: 50%;
	}
}
</style>
