const state = {
    guest: localStorage.getItem('guest')
}

const getters = {
    guest: state => {
        return state.guest
    }
}

const actions = {
    getIsGuest({state,commit,dispatch}) {
        axios.get(`/api/authenticated`)
            .then(data => {
                commit('setIsGuest', data.data)
            })
    },
}

const mutations = {
    setIsGuest(state, guest) {
        state.guest = guest;
    }
}

export default {
    state, mutations, getters, actions
}