package anon.network.ui;

import androidx.appcompat.app.AppCompatActivity;

import android.app.ProgressDialog;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.Toast;

import com.google.android.material.textfield.TextInputEditText;
import com.google.android.material.textfield.TextInputLayout;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedInputStream;
import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.util.HashMap;

import anon.network.R;
import anon.network.models.UsuarioModel;
import anon.network.service.ApiService;

public class LoginActivity extends AppCompatActivity {

    private static final String logMessage = "LogMessage";

    private UsuarioModel usuarioModel;

    private Button btnLogin;
    private TextInputEditText txtUsuario;
    private TextInputEditText txtPassword;

    private String line;
    private int responseCode;
    private JSONObject jsonObject;
    private InputStream inputStream;
    private StringBuilder stringBuilder;
    private HttpURLConnection httpURLConnection;
    private BufferedReader bufferedReader;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        usuarioModel = new UsuarioModel();

        txtUsuario = (TextInputEditText) findViewById(R.id.txtUsuario);
        txtPassword = (TextInputEditText) findViewById(R.id.txtPassword);
        btnLogin = (Button) findViewById(R.id.btnLogin);

        btnLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                usuarioModel.setUsuario(txtUsuario.getText().toString());
                usuarioModel.setPassword(txtPassword.getText().toString());

                if (usuarioModel.getUsuario().isEmpty()) {
                    Log.i(logMessage, "Ingrese su nombre de usuario");
                    txtUsuario.setText("");
                    txtUsuario.isFocusable();
                }

                if (usuarioModel.getPassword().isEmpty()) {
                    Log.i(logMessage, "Ingrese su contraseña");
                    txtPassword.setText("");
                    txtPassword.isFocusable();
                }
            }
        });
    }

    private class validateUser extends AsyncTask <String, String, JSONObject> {

        private ApiService apiService = new ApiService();
        private ProgressDialog progressDialog;

        private static final String urlComplement = "/usuario/login";
        private static final String jsonResponse = "Mensaje";
        private static final String method = "POST";
        private static final String style = "normal";

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            progressDialog = new ProgressDialog(LoginActivity.this);
            progressDialog.setTitle("Validando usuario");
            progressDialog.setMessage("Espere unos segundos por favor!");
            progressDialog.setIndeterminate(true);
            progressDialog.setCancelable(true);
            progressDialog.show();
        }

        @Override
        protected JSONObject doInBackground(String... strings) {

            try {

                HashMap<String, String> params = new HashMap<>();
                params.put("usuario", usuarioModel.getUsuario());
                params.put("clave", usuarioModel.getPassword());

                httpURLConnection = apiService.ServiceSF(params, urlComplement, method, style);

                try {

                    responseCode = httpURLConnection.getResponseCode();

                    if (responseCode == 404) {
                        inputStream = new BufferedInputStream(httpURLConnection.getErrorStream());
                        bufferedReader = new BufferedReader(new InputStreamReader(inputStream));
                        stringBuilder = new StringBuilder();

                        while ((line = bufferedReader.readLine()) != null) {
                            stringBuilder.append(line);
                        }

                        try {
                            jsonObject = new JSONObject(stringBuilder.toString());

                            if (jsonObject != null) {
                                Log.i(logMessage, jsonObject.getString(jsonResponse));
                            }
                        } catch (JSONException jsonException) {
                             jsonException.printStackTrace();
                        }
                    } else if (responseCode == 200) {
                        inputStream = new BufferedInputStream(httpURLConnection.getInputStream());
                        bufferedReader = new BufferedReader(new InputStreamReader(inputStream));
                        stringBuilder = new StringBuilder();

                        while ((line = bufferedReader.readLine()) != null) {
                            stringBuilder.append(line);
                        }

                        try {
                            jsonObject = new JSONObject(stringBuilder.toString());

                            if (jsonObject != null) {
                                JSONArray jsonArray = jsonObject.getJSONArray(jsonResponse);
                                Log.i(logMessage, jsonArray.toString());

                                for (int i = 0; i < jsonArray.length(); i++) {
                                    JSONObject jsonObjectUsuario = jsonArray.getJSONObject(i);
                                    Log.i(logMessage, jsonObjectUsuario.toString());
                                }
                            }
                        } catch (JSONException jsonException) {
                            jsonException.printStackTrace();
                        }
                    }

                } catch (IOException e) {
                    e.printStackTrace();
                }

                return jsonObject;

            } catch (Exception e) {
                e.printStackTrace();
            }

            return null;
        }

        @Override
        protected void onPostExecute(JSONObject jsonObject) {
            super.onPostExecute(jsonObject);
        }
    }
}
