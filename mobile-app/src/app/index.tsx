import { StyleSheet, ActivityIndicator, Platform, StatusBar } from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';
import { WebView } from 'react-native-webview';

export default function App() {
  return (
    <SafeAreaView style={styles.container}>
      <WebView 
        source={{ uri: 'http://10.23.173.120:8000/login' }} 
        style={styles.webview}
        bounces={false}
        overScrollMode="never"
        showsVerticalScrollIndicator={false}
        showsHorizontalScrollIndicator={false}
        scalesPageToFit={false}
        setBuiltInZoomControls={false}
        textZoom={100}
        startInLoadingState={true}
        renderLoading={() => (
          <ActivityIndicator 
            color="#c5010f" 
            size="large" 
            style={styles.loader} 
          />
        )}
      />
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#ffffff', // Use white to match the top bar of the website
    paddingTop: Platform.OS === 'android' ? StatusBar.currentHeight : 0,
  },
  webview: {
    flex: 1,
    backgroundColor: 'transparent',
  },
  loader: {
    ...StyleSheet.absoluteFillObject,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#0a0a0a',
    zIndex: 10,
  }
});
