const state = {
    lang: 'en'
}

const getters = {
    lang: state => {
        return state.lang
    }
}

const actions = {
    getLang({state,commit,dispatch}, param) {
        // axios.get(`/api/getLang`)
        //     .then(data => {
                commit('setLang', param.lang)
            // })
    },
}

const mutations = {
    setLang(state, lang) {
        state.lang = lang;
    }
}

export default {
    state, mutations, getters, actions
}