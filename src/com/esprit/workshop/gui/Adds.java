package com.esprit.workshop.gui;

import com.esprit.workshop.entites.Gamer;
import com.esprit.workshop.entites.notif;
import com.esprit.workshop.services.ServiceTournoi;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Node;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.*;
import javafx.scene.layout.VBox;
import javafx.stage.Stage;

import java.io.IOException;
import java.net.URL;
import java.sql.SQLException;
import java.util.List;
import java.util.ResourceBundle;

public class Adds implements Initializable {
ServiceTournoi t = new ServiceTournoi();
    @FXML
    private Label nbnotif;
    @FXML
    private ListView<String> notificationList;
    @FXML
    private Button notif;
    @FXML
    void addteams(ActionEvent event) throws IOException {
        Parent root = FXMLLoader.load(getClass().getResource("Addteam.fxml"));

        Stage stage = (Stage) ((Node) event.getSource()).getScene().getWindow();
        Scene scene = new Scene(root);
        stage.setScene(scene);
        stage.show();

    }

    @FXML
    void addtournois(ActionEvent event) throws IOException {
        Parent root = FXMLLoader.load(getClass().getResource("Ajoutertournoi.fxml"));

        Stage stage = (Stage) ((Node) event.getSource()).getScene().getWindow();
        Scene scene = new Scene(root);
        stage.setScene(scene);
        stage.show();
    }


    @FXML
    public void initialize(URL url, ResourceBundle rb) {
        Gamer g = new Gamer();
        g.setId(3);
        try {
            int count = t.affichenbnotif(g.getId());
            nbnotif.setText(String.valueOf(count));
        } catch (SQLException e) {
            e.printStackTrace();
        }

        // Set the number of notifications in the nbnotif Label

    }



    public void affichetournoi(ActionEvent event) throws IOException {
        Parent root = FXMLLoader.load(getClass().getResource("tournoi.fxml"));

        Stage stage = (Stage) ((Node) event.getSource()).getScene().getWindow();
        Scene scene = new Scene(root);
        stage.setScene(scene);
        stage.show();
    }
    @FXML
    private void showNotificationsDialog(ActionEvent event) {
        Gamer g = new Gamer();
        g.setId(3);
        try {
            List<notif> notifications = t.getNotificationsForGamer(g.getId());

                // Create a dialog to display the notification content
                // Create a dialog to display the notification content
                Dialog<Void> dialog = new Dialog<>();
                dialog.setTitle("Notification");
                dialog.setHeaderText("Notification for gamer " + g.getId());

                 ButtonType okButton = new ButtonType("OK", ButtonBar.ButtonData.OK_DONE);
                dialog.getDialogPane().getButtonTypes().addAll(okButton, ButtonType.CANCEL);

                 VBox vbox = new VBox();

                 for (notif n : notifications) {
                     Label contentLabel = new Label(n.getContent());
                     vbox.getChildren().add(contentLabel);
                }

// Set the content of the dialog to the VBox
                dialog.getDialogPane().setContent(vbox);

// Show the dialog
                dialog.showAndWait();


        } catch (SQLException throwables) {
            throwables.printStackTrace();
        }

    }


}
