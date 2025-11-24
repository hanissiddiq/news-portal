import { ref } from 'vue';
import api from '../api/axios';

const user = ref(null);
const token = ref(localStorage.getItem('token') || null);
if(token.value) api.defaults.headers.common['Authorization'] = 'Bearer ' + token.value;

export function useAuth(){
  const login = async (email, password) => {
    const res = await api.post('/login', { email, password });
    token.value = res.data.token;
    localStorage.setItem('token', token.value);
    api.defaults.headers.common['Authorization'] = 'Bearer ' + token.value;
    user.value = res.data.user;
    return res.data;
  };
  const register = async (payload) => {
    const res = await api.post('/register', payload);
    token.value = res.data.token;
    localStorage.setItem('token', token.value);
    api.defaults.headers.common['Authorization'] = 'Bearer ' + token.value;
    user.value = res.data.user;
    return res.data;
  };
  const logout = async () => {
    try { await api.post('/logout'); } catch(e){}
    localStorage.removeItem('token');
    token.value = null;
    user.value = null;
    delete api.defaults.headers.common['Authorization'];
  };
  const fetchMe = async () => {
    if(!token.value) return;
    const res = await api.get('/me');
    user.value = res.data;
  };
  return { user, token, login, register, logout, fetchMe };
}
