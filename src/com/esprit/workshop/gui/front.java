package com.esprit.workshop.gui;

import animatefx.animation.FadeInDown;
import javafx.scene.input.MouseEvent;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Alert;
import javafx.scene.control.Button;
import javafx.scene.control.TextField;
import javafx.scene.layout.AnchorPane;
import javafx.scene.layout.BorderPane;
import javafx.stage.Stage;
import javafx.fxml.Initializable;
import java.io.IOException;
import java.net.URL;
import java.util.Objects;
import java.util.ResourceBundle;

public class front implements Initializable {
    @FXML
    private final BorderPane bp;
    @FXML
    private AnchorPane ap;
    @FXML
    void coach(MouseEvent event) {
        loadPage("AjouterPersonFXML.fxml");
    }
    public front() {
        bp = new BorderPane();
    }
    @FXML
    void groupe(MouseEvent event) {
        loadPage("AjouterPersonFXML.fxml");
    }

    @FXML
    void home(MouseEvent event) {
        bp.setCenter(ap);
    }

    @FXML
    void news(MouseEvent event) {
        loadPage("AjouterPersonFXML.fxml");
    }

    @FXML
    void produit(MouseEvent event) {
        loadPage("AjouterPersonFXML.fxml");
    }

    @FXML
    void tournoi(MouseEvent event) {
    loadPage("Ajoutertournoi.fxml");
    }
    @Override
    public void initialize(URL url, ResourceBundle resourceBundle) {

    }
    private void loadPage(String page) {
        Parent root = null;
        try {
            root = FXMLLoader.load(Objects.requireNonNull(getClass().getResource(page)));

        } catch (IOException ex) {
            System.err.println(ex.getMessage());
        }
        bp.setCenter(root);
    }



}
