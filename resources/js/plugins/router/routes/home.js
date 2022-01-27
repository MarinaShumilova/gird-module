// компоненты
import Home from "../../../views/Home"

export default [
    // обязательный роут, редирект после ошибок
    // если нужен другой стартовый роут, делаем редирект
    {
        path: "/",
        name: "home",
        component: Home,
        meta: {
            auth: true,
            title: 'Home'
        }
    }
]
