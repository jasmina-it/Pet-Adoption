document.addEventListener("DOMContentLoaded", () => {
    // Mobile navigation menu
    document.querySelectorAll(".menu-toggle").forEach((toggle) => {
        const nav = toggle.parentElement.querySelector(".nav-links");
        if (!nav) return;

        toggle.addEventListener("click", () => {
            const isOpen = nav.classList.toggle("open");
            toggle.setAttribute("aria-expanded", String(isOpen));
            toggle.setAttribute("aria-label", isOpen ? "Закрыть меню" : "Открыть меню");
        });

        nav.querySelectorAll("a").forEach((link) => {
            link.addEventListener("click", () => {
                nav.classList.remove("open");
                toggle.setAttribute("aria-expanded", "false");
                toggle.setAttribute("aria-label", "Открыть меню");
            });
        });
    });

    // Animal catalog
    const animalCards = [...document.querySelectorAll(".animal-card")];
    const searchInput = document.querySelector("#animalSearch");
    const filterButtons = [...document.querySelectorAll(".filter-btn")];
    let activeFilter = "all";

    function filterAnimals() {
        if (!animalCards.length) return;
        const searchText = (searchInput?.value || "").trim().toLocaleLowerCase("ru");
        let visibleCount = 0;

        animalCards.forEach((card) => {
            const name = card.querySelector("h2")?.textContent.toLocaleLowerCase("ru") || "";
            const typeMatches = activeFilter === "all" || card.dataset.type === activeFilter;
            const searchMatches = name.includes(searchText);
            const visible = typeMatches && searchMatches;
            card.hidden = !visible;
            if (visible) visibleCount++;
        });

        let message = document.querySelector(".no-results");
        if (!message) {
            message = document.createElement("p");
            message.className = "no-results";
            message.textContent = "По вашему запросу питомцы не найдены.";
            document.querySelector(".animal-grid")?.append(message);
        }
        message.hidden = visibleCount > 0;
    }

    if (animalCards.length) {
        searchInput?.addEventListener("input", filterAnimals);
        filterButtons.forEach((button) => {
            button.addEventListener("click", () => {
                activeFilter = button.dataset.filter || "all";
                filterButtons.forEach((item) => item.classList.toggle("active", item === button));
                filterAnimals();
            });
        });
        filterAnimals();
    }

    // Login / registration 
    const authForm = document.querySelector("#authForm");
    if (authForm) {
        const tabs = [...document.querySelectorAll(".auth-tab")];
        const title = document.querySelector("#authTitle");
        const subtitle = document.querySelector("#authSubtitle");
        const nameGroup = document.querySelector("#nameGroup");
        const nameInput = document.querySelector("#fullName");
        const confirmGroup = document.querySelector("#confirmGroup");
        const confirmInput = document.querySelector("#confirmPassword");
        const emailInput = document.querySelector("#email");
        const passwordInput = document.querySelector("#password");
        const submitButton = document.querySelector("#submitButton");
        const message = document.querySelector("#formMessage");
        let mode = "login";

        function setMode(nextMode) {
            mode = nextMode;
            const isRegister = mode === "register";
            title.textContent = isRegister ? "Создать аккаунт" : "С возвращением!";
            subtitle.textContent = isRegister
                ? "Зарегистрируйтесь, чтобы сделать первый шаг к усыновлению."
                : "Войдите, чтобы продолжить знакомство с питомцами.";
            nameGroup.hidden = !isRegister;
            confirmGroup.hidden = !isRegister;
            nameInput.required = isRegister;
            confirmInput.required = isRegister;
            passwordInput.autocomplete = isRegister ? "new-password" : "current-password";
            submitButton.textContent = isRegister ? "Зарегистрироваться" : "Войти";
            tabs.forEach((tab) => tab.classList.toggle("active", tab.dataset.mode === mode));
            message.textContent = "";
            message.className = "form-message";
        }

        tabs.forEach((tab) => tab.addEventListener("click", () => setMode(tab.dataset.mode)));
        authForm.addEventListener("submit", (event) => {
            event.preventDefault();
            message.textContent = "";
            message.className = "form-message";

            if (!emailInput.validity.valid) {
                message.textContent = "Введите корректный адрес электронной почты.";
                message.classList.add("error");
                emailInput.focus();
                return;
            }
            if (passwordInput.value.length < 8) {
                message.textContent = "Пароль должен содержать минимум 8 символов.";
                message.classList.add("error");
                passwordInput.focus();
                return;
            }
            if (mode === "register") {
                if (!nameInput.value.trim()) {
                    message.textContent = "Введите своё имя.";
                    message.classList.add("error");
                    nameInput.focus();
                    return;
                }
                if (passwordInput.value !== confirmInput.value) {
                    message.textContent = "Пароли не совпадают. Проверьте ввод.";
                    message.classList.add("error");
                    confirmInput.focus();
                    return;
                }
                message.textContent = "Форма заполнена корректно. Подключение регистрации появится на этапе backend.";
            } else {
                message.textContent = "Форма заполнена корректно. Реальная авторизация будет подключена на этапе backend.";
            }
            message.classList.add("success");
        });
    }

    // Demo action for the animal cards
    document.querySelectorAll(".animal-btn").forEach((button) => {
        button.addEventListener("click", () => {
            const card = button.closest(".animal-card");
            const petName = card?.querySelector("h2")?.textContent || "питомца";
            alert(`Вы выбрали ${petName}! На следующем этапе здесь можно будет оформить заявку на усыновление.`);
        });
    });
});
