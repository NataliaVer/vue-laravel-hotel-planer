const state = {
    hotel: null
}

const getters = {
    hotel: state => {
        return state.hotel
    }
}

const actions = {
    getHotel({state,commit,dispatch}, param) {
        axios.get(`/api/hotel/${param.id}/${param.dateFrom}/${param.dateTo}`)
            .then(data => {
                commit('setHotel', data.data)
            })
    },
}

const mutations = {
    setHotel(state, hotel) {
        state.hotel = hotel
    }
}

export default {
    state, mutations, getters, actions
}