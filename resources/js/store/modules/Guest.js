const state = {
    guest: true
}

const getters = {
    guest: state => {
        return state.guest
    }
}

const actions = {
    getIsGuest({state,commit,dispatch}) {
        axios.get(`/api/isGuest`)
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