import React, { useState, useEffect } from 'react';
import { StyleSheet, Text, View, TextInput, TouchableOpacity, FlatList, SafeAreaView } from 'react-native';

const API_BASE_URL = 'https://loose-shirts-raise.loca.lt/api/v1';

export default function App() {
  const [token, setToken] = useState(null);
  const [userId, setUserId] = useState(null);
  const [email, setEmail] = useState('siddharthchhayani11@gmail.com');
  const [password, setPassword] = useState('siddharthchhayani11@gmail.com');
  const [chats, setChats] = useState([]);
  const [usersMap, setUsersMap] = useState({});
  const [loading, setLoading] = useState(false);
  const [currentChat, setCurrentChat] = useState(null);
  const [messages, setMessages] = useState([]);

  const handleLogin = async () => {
    setLoading(true);
    try {
      const response = await fetch(`${API_BASE_URL}/login`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Bypass-Tunnel-Reminder': 'true'
        },
        body: JSON.stringify({ email: email, password: password })
      });
      const data = await response.json();
      if (data.data && data.data.token) {
        setToken(data.data.token);
        setUserId(data.data.user.id);
        fetchChats(data.data.token);
      } else {
        alert('Login failed');
      }
    } catch (e) {
      alert('Fetch error: ' + e.message);
      console.error(e);
    }
    setLoading(false);
  };

  const fetchChats = async (authToken) => {
    try {
      const usersRes = await fetch(`${API_BASE_URL}/users`, {
        headers: {
          'Authorization': `Bearer ${authToken}`,
          'Accept': 'application/json',
          'Bypass-Tunnel-Reminder': 'true'
        }
      });
      const usersData = await usersRes.json();
      const map = {};
      if (usersData.data) {
        usersData.data.forEach(u => map[u.id] = u.name);
      }
      setUsersMap(map);

      const response = await fetch(`${API_BASE_URL}/chats`, {
        headers: {
          'Authorization': `Bearer ${authToken}`,
          'Accept': 'application/json',
          'Bypass-Tunnel-Reminder': 'true'
        }
      });
      const data = await response.json();
      if (data.data) {
        const chatArray = Array.isArray(data.data) ? data.data : Object.entries(data.data).map(([id, chat]) => ({ ...chat, id }));
        setChats(chatArray);
      }
    } catch (e) {
      console.error(e);
    }
  };

  const openChat = async (chat) => {
    setCurrentChat(chat);
    setMessages([]);
    try {
      const response = await fetch(`${API_BASE_URL}/messages/${chat.id}`, {
        headers: {
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json',
          'Bypass-Tunnel-Reminder': 'true'
        }
      });
      const data = await response.json();
      if (data.data) {
        const msgArray = Array.isArray(data.data) ? data.data : Object.values(data.data);
        setMessages(msgArray.sort((a, b) => a.time - b.time));
      }
    } catch(e) {
      console.error(e);
    }
  };

  const getChatName = (item) => {
    if (item.name) return item.name;
    if (item.is_broadcast) return 'Broadcast List';
    if (item.users) {
      const otherId = item.users.find(id => id !== userId);
      return usersMap[otherId] || 'User';
    }
    return 'Chat';
  };

  if (!token) {
    return (
      <SafeAreaView style={styles.container}>
        <View style={styles.loginBox}>
          <Text style={styles.title}>Welcome to Chat App</Text>
          <TextInput style={styles.input} value={email} onChangeText={setEmail} placeholder="Email" keyboardType="email-address" />
          <TextInput style={styles.input} value={password} onChangeText={setPassword} placeholder="Password" secureTextEntry />
          <TouchableOpacity style={styles.button} onPress={handleLogin} disabled={loading}>
            <Text style={styles.buttonText}>{loading ? 'Logging in...' : 'Log In'}</Text>
          </TouchableOpacity>
        </View>
      </SafeAreaView>
    );
  }

  if (currentChat) {
    return (
      <SafeAreaView style={styles.container}>
        <View style={styles.header}>
          <TouchableOpacity onPress={() => setCurrentChat(null)} style={{marginRight: 15}}>
            <Text style={{color: '#fff', fontSize: 16}}>{"< Back"}</Text>
          </TouchableOpacity>
          <Text style={styles.headerText}>{getChatName(currentChat)}</Text>
        </View>
        <FlatList
          data={messages}
          keyExtractor={(item, index) => (item.id || index).toString()}
          contentContainerStyle={{ padding: 15 }}
          renderItem={({ item }) => {
            const isMe = item.sender_id === userId;
            return (
              <View style={[styles.messageBubble, isMe ? styles.messageMe : styles.messageThem]}>
                <Text style={styles.messageText}>{item.text}</Text>
              </View>
            );
          }}
        />
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
        keyExtractor={(item, index) => (item.id || index).toString()}
        contentContainerStyle={{ flexGrow: 1 }}
        ListEmptyComponent={<View style={{flex:1, justifyContent:'center', alignItems:'center'}}><Text style={{ color: '#666', fontSize: 16 }}>No chats yet. Messages will appear here.</Text></View>}
        renderItem={({ item }) => (
          <TouchableOpacity style={styles.chatItem} onPress={() => openChat(item)}>
            <View style={styles.avatar} />
            <View style={styles.chatInfo}>
              <Text style={styles.chatName}>{getChatName(item)}</Text>
              <Text style={styles.chatMessage}>{item.last_message || (item.text ? item.text : 'No messages yet')}</Text>
            </View>
          </TouchableOpacity>
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
    fontSize: 18,
    fontWeight: 'bold',
  },
  header: {
    backgroundColor: '#075e54',
    padding: 20,
    paddingTop: 40,
    flexDirection: 'row',
    alignItems: 'center',
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
    fontWeight: 'bold',
    fontSize: 16,
    marginBottom: 5,
  },
  chatMessage: {
    color: '#666',
  },
  messageBubble: {
    padding: 12,
    borderRadius: 15,
    marginBottom: 10,
    maxWidth: '80%',
  },
  messageMe: {
    backgroundColor: '#DCF8C6',
    alignSelf: 'flex-end',
    borderBottomRightRadius: 0,
  },
  messageThem: {
    backgroundColor: '#EAEAEA',
    alignSelf: 'flex-start',
    borderBottomLeftRadius: 0,
  },
  messageText: {
    fontSize: 16,
  }
});
