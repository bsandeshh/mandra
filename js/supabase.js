(function(){
  // Load config injected by PHP
  if (!window.__SUPABASE_PUBLIC__) {
    console.warn('Supabase public config is not available. Ensure public-config.php is included.');
    window.__SUPABASE_PUBLIC__ = { url: '', anonKey: '' };
  }
  window.supabaseBootstrap = function(){
    return window.__SUPABASE_PUBLIC__;
  };
})();


