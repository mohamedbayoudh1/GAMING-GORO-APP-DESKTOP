package com.esprit.workshop.gui;

import com.esprit.workshop.entites.Gamer;
import com.esprit.workshop.entites.Team;
import com.esprit.workshop.entites.Tournoi;
import com.esprit.workshop.services.ServiceTeam;
import com.esprit.workshop.services.ServiceTournoi;
import com.esprit.workshop.services.serviceclassement;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.geometry.Pos;
import javafx.scene.Node;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Alert;
import javafx.scene.control.Button;
import javafx.scene.control.ChoiceDialog;
import javafx.scene.control.Label;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.layout.FlowPane;
import javafx.scene.layout.VBox;
import javafx.stage.Stage;
import twitter4j.*;
import twitter4j.conf.ConfigurationBuilder;

import java.io.FileInputStream;
import java.io.IOException;
import java.net.URL;
import java.sql.SQLException;
import java.util.List;
import java.util.Optional;
import java.util.ResourceBundle;
import java.util.stream.Collectors;


public class tournoire implements Initializable {



      @FXML
    private FlowPane imagePane;

    public void initialize(URL url, ResourceBundle resourceBundle) {
        try {
            loadImage();
        } catch (SQLException | IOException | TwitterException throwables) {
            throwables.printStackTrace();
        }
    }

    @FXML
    void loadImage() throws SQLException, IOException , TwitterException{
        List<Tournoi> listTournoi = new ServiceTournoi().selectAll();
        Gamer g = new Gamer();
        g.setId(3);
        for (Tournoi t : listTournoi) {
           String imageFile = "C:/Users/bayou/Desktop/WorkshopJDBC3A37/src/com/esprit/workshop/uploadtournoi/" + t.getImage();
             Image img = new Image(new FileInputStream(imageFile));
             ImageView iv = new ImageView(img);
             iv.setFitWidth(200);
            iv.setFitHeight(200);
            Label lbl = new Label(t.getNomtournoi());
            Button btn = new Button("Rejoinder!");
            Button shareButton = new Button("Share on Twitter");

            // Event handler for the button
             btn.setOnAction(e -> {
                try {
                    // Show a dialog to select the team
                    List<Team> teams = new ServiceTeam().selectoneteam(g);
                    List<String> teamNames = teams.stream().map(Team::getNom_team).collect(Collectors.toList());
                    ChoiceDialog<String> dialog = new ChoiceDialog<>(teamNames.get(0), teamNames);
                    dialog.setTitle("Select a team");
                    dialog.setHeaderText("Select a team to add to the tournament");
                    dialog.setContentText("Team:");

                    Optional<String> result = dialog.showAndWait();
                    if (result.isPresent()) {
                        // Insert the record into the Classement table
                        String selectedTeamName = result.get();
                        Team selectedTeam = teams.stream().filter(team -> team.getNom_team().equals(selectedTeamName)).findFirst().orElse(null);
                        new serviceclassement().addClassement(t,selectedTeam);
                        Alert alert = new Alert(Alert.AlertType.INFORMATION);
                        alert.setTitle("Success");
                        alert.setHeaderText(null);
                        alert.setContentText("Team added to tournament successfully!");
                        alert.showAndWait();
                    }
                } catch (SQLException ex) {
                    Alert alert = new Alert(Alert.AlertType.ERROR);
                    alert.setTitle("Error");
                    alert.setHeaderText(null);
                    alert.setContentText("An error occurred while adding the team to the tournament.");
                    alert.showAndWait();
                }
            });
            shareButton.setOnAction(e -> {
                // Set up Twitter API credentials and keys
                String consumerKey = "b0Xvmoj7BUCnc12ocuUg5A7pl";
                String consumerSecret = "G7FtmqUEtmvAJRKF0pvWaN0SaX7zAxfFWxie5kzy6MSjxVCaze";
                String AccessToken = "1609135822728564736-TPjddUsY8zTmhzyKN0V7xVDR7N2xcQ";
                String AccessTokenSecret = "YoPF5Qqv6x3lwwZOj8Ue2k5YsffKEL7CeIkVkPBIq2dAx";
                String bearerToken = "AAAAAAAAAAAAAAAAAAAAAG6gmwEAAAAA18K4UKMRZ92CAIQun49ONz%2Bx6bU%3DC1b8BJIJKL0pa7J8tI8QIBhAYsSxvR9hcHu0DlC1TyoDaw3cda";

                ConfigurationBuilder cb = new ConfigurationBuilder();

                cb.setDebugEnabled(true)
                        .setOAuthConsumerKey(consumerKey)
                        .setOAuthConsumerSecret(consumerSecret)
                        .setOAuthAccessToken(AccessToken)
                        .setOAuthAccessTokenSecret(AccessTokenSecret);
                Twitter twitter = new TwitterFactory(cb.build()).getInstance();
                try {
                    Status status = twitter.updateStatus("Hello, World!");
                    System.out.println("Successfully tweeted: " + status.getText());
                } catch (TwitterException e1) {
                    e1.printStackTrace();
                }



            });
            VBox box = new VBox(iv,lbl, btn,shareButton);
            box.setSpacing(10);
            box.setAlignment(Pos.CENTER);
            imagePane.getChildren().add(box);


        }
    }


    public void btnretour(ActionEvent event) throws IOException {
        Parent root = FXMLLoader.load(getClass().getResource("adds.fxml"));

        Stage stage = (Stage) ((Node) event.getSource()).getScene().getWindow();
        Scene scene = new Scene(root);
        stage.setScene(scene);
        stage.show();

    }
}
