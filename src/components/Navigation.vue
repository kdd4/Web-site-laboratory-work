<script setup>
import { RouterLink, useRoute } from 'vue-router'
import { ref } from 'vue'

const route = useRoute()

function currentPage() {
	return this.route == route.path
}

const navigation_buttons = ref([
	{ route: '/', text: 'Главная', currentPage },
	{ route: '/aboutme', text: 'Обо мне', currentPage },
	{ route: '/myinterests', text: 'Мои интересы', currentPage },
	{ route: '/study', text: 'Учеба', currentPage },
	{ route: '/photoalbum', text: 'Фотоальбом', currentPage },
	{ route: '/contact', text: 'Контакт', currentPage },
	{ route: '/test', text: 'Тест по дисциплине', currentPage },
])

route.path
</script>

<template>
	<header>
		<input type="checkbox" id="burger-checkbox" />
		<label id="burger-button-img" for="burger-checkbox">
			<img src="/src/assets/images/menu_button.jpg" alt="menu" />
		</label>
		<h1>LW1</h1>
		<ul id="nav-buttons">
			<li v-for="button in navigation_buttons">
				<RouterLink :to="button.route" :class="{ CurrentPage: button.currentPage() }">
					{{ button.text }}
				</RouterLink>
			</li>
		</ul>
	</header>
</template>

<style scoped>
header {
	--nav_color: black;
	--nav_button_color: gainsboro;
	--nav_button_text_color: black;
}

header {
	display: flex;
	justify-content: space-evenly;
	align-items: center;

	margin: 0em 0em 2em 0em;
	background-color: var(--nav_color);
}

#burger-checkbox {
	display: none;
}

#burger-button-img {
	margin: 0.5em;
}

#burger-button-img img {
	display: none;
	border-radius: 10%;
	width: 2em;
	height: 2em;
}

header h1 {
	flex-grow: 0;
	margin: 0em 0.4em 0em 0.4em;

	color: white;

	transition: all 1s linear(0, 0.4 25%, 1) 0s;
}

header h1:hover {
	transform: rotate(45deg);
}

#nav-buttons {
	display: flex;
	flex-wrap: nowrap;
	justify-content: space-evenly;
	flex-grow: 1;

	list-style: none;
	padding: 0;
}

#nav-buttons li {
	display: flex;
	justify-content: center;
}

#nav-buttons a {
	margin: 0em 0.2em 0em 0.2em;
	padding: 0.2em;
	background-color: var(--nav_button_color);
	border-radius: 5%;
	border: 3px solid var(--nav_button_color);

	white-space: nowrap;
	text-decoration: none;
	color: var(--nav_button_text_color);

	transition: all 0.5s ease 0s;
}

#nav-buttons a:hover {
	transform: scale(1.05);
}

#nav-buttons a.CurrentPage {
	border: 0.2em solid green;
}

@media (max-width: 800px) {
	#nav-buttons {
		flex-wrap: wrap;
	}

	#nav-buttons li {
		margin-top: 0.75em;
		margin-bottom: 0.75em;
	}
}

@media (max-width: 500px) {
	header {
		flex-direction: column;
	}

	header h1 {
		display: none;
	}

	#nav-buttons {
		display: none;
		flex-direction: column;
		justify-content: center;
	}

	#nav-buttons li {
		display: flex;
		align-items: center;
	}

	#burger-button-img img {
		display: block;

		transition: all 0.5s ease 0s;
	}

	#burger-checkbox:checked ~ #nav-buttons {
		display: block;
	}

	#burger-checkbox:checked ~ #burger-button-img img {
		filter: invert(1);
		transform: rotate(90deg);
	}
}
</style>
