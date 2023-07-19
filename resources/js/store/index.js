
import { createStore } from 'vuex'
import Hotel from './modules/Hotel'

// Create a new store instance.
const store = createStore({
  modules: {
    Hotel: Hotel,
  }
})

// Install the store instance as a plugin
export default store;