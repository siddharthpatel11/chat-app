import { useState, useEffect } from 'react';
import { StyleSheet, Text, View, TextInput, TouchableOpacity, FlatList, SafeAreaView } from 'react-native';

const API_BASE_URL = 'http://127.0.0.1:8000/api/v1';

export default function App() {
  const [token, setToken] = useState(null);
  const [phone, setPhone] = useState('9876543210');
  const [password, setPassword] = useState('password');
  const [chats, setChats] = useState([]);
  const [loading, setLoading] = useState(false);

  const handleLogin = async () => {
    setLoading(true);
    try {
      const response = await fetch(`${API_BASE_URL}/login`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        body: JSON.stringify({ phone_number: phone, password: password })
      });
      const data = await response.json();
      if (data.data && data.data.token) {
        setToken(data.data.token);
        fetchChats(data.data.token);
      } else {
        alert('Login failed');
      }
    } catch (e) {
      alert('Error connecting to API');
    }
    setLoading(false);
  };

  const fetchChats = async (authToken) => {
    try {
      const response = await fetch(`${API_BASE_URL}/profile/chats`, {
        headers: {
          'Authorization': `Bearer ${authToken}`,
          'Accept': 'application/json'
        }
      });
      const data = await response.json();
      if (data.data) {
        setChats(data.data);
      }
    } catch (e) {
      console.error(e);
    }
  };

  if (!token) {
    return (
      <SafeAreaView style={styles.container}>
        <View style={styles.loginBox}>
          <Text style={styles.title}>Welcome to Chat App</Text>
          <TextInput style={styles.input} value={phone} onChangeText={setPhone} placeholder="Phone Number" keyboardType="phone-pad" />
          <TextInput style={styles.input} value={password} onChangeText={setPassword} placeholder="Password" secureTextEntry />
          <TouchableOpacity style={styles.button} onPress={handleLogin} disabled={loading}>
            <Text style={styles.buttonText}>{loading ? 'Logging in...' : 'Log In'}</Text>
          </TouchableOpacity>
        </View>
      </SafeAreaView>
    );
  }

  return (
    <SafeAreaView style={styles.container}>
      <View style={styles.header}>
        <Text style={styles.headerText}>Chats</Text>
      </View>
      <FlatList
        data={chats}
        keyExtractor={(item) => item.id.toString()}
        renderItem={({ item }) => (
          <View style={styles.chatItem}>
            <View style={styles.avatar} />
            <View style={styles.chatInfo}>
              <Text style={styles.chatName}>{item.chat_name || 'Group Chat'}</Text>
              <Text style={styles.chatMessage}>{item.last_message || 'No messages yet'}</Text>
            </View>
          </View>
        )}
      />
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#fff',
  },
  loginBox: {
    flex: 1,
    justifyContent: 'center',
    padding: 20,
  },
  title: {
    fontSize: 24,
    fontWeight: 'bold',
    marginBottom: 20,
    textAlign: 'center',
    color: '#075e54',
  },
  input: {
    borderWidth: 1,
    borderColor: '#ccc',
    padding: 15,
    borderRadius: 8,
    marginBottom: 15,
    fontSize: 16,
  },
  button: {
    backgroundColor: '#25D366',
    padding: 15,
    borderRadius: 8,
    alignItems: 'center',
  },
  buttonText: {
    color: '#fff',
    fontSize: 16,
    fontWeight: 'bold',
  },
  header: {
    backgroundColor: '#075e54',
    padding: 20,
    paddingTop: 40,
  },
  headerText: {
    color: '#fff',
    fontSize: 20,
    fontWeight: 'bold',
  },
  chatItem: {
    flexDirection: 'row',
    padding: 15,
    borderBottomWidth: 1,
    borderBottomColor: '#eee',
    alignItems: 'center',
  },
  avatar: {
    width: 50,
    height: 50,
    borderRadius: 25,
    backgroundColor: '#ccc',
    marginRight: 15,
  },
  chatInfo: {
    flex: 1,
  },
  chatName: {
    fontSize: 16,
    fontWeight: 'bold',
    marginBottom: 5,
  },
  chatMessage: {
    color: '#666',
  }
});
