import { StyleSheet, ActivityIndicator, View } from 'react-native';
import { WebView } from 'react-native-webview';

export default function App() {
  return (
    <View style={styles.container}>
      <WebView 
        source={{ uri: 'http://10.71.157.120:8000/login' }} 
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
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#0a0a0a', // Dark background matching the splash screen
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
