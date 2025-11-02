<script setup></script>

<template>
	<main>
		<h2>Камышов<br />Даниил<br />Денисович</h2>
		<img class="myPhoto" src="/src/assets/images/me.jpg" alt="Моя фотография" />
		<h2>ИС/б-23-2-о<br />Лаборатороная работа №1</h2>
	</main>
</template>

<style scoped>
main {
	display: flex;
	justify-content: center;
	align-items: center;
}

main h2 {
	font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
}

.myPhoto {
	width: 20em;
	padding: 0em 3em 0em 3em;

	transition: all 0.5s ease 0s;
}

.myPhoto:hover {
	transform: rotateY(45deg) rotateX(-45deg) scale(0.8);
}

@media (max-width: 600px) {
	main {
		flex-direction: column;
	}
}
</style>
